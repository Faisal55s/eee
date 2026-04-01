/**
 * ARMAX - Admin Panel JavaScript
 */

// Check if admin is logged in
async function checkAuth() {
    const result = await apiRequest('auth.php');
    
    if (!result.authenticated || result.user.role !== 'admin') {
        window.location.href = 'login.html';
        return false;
    }
    
    return true;
}

// Load admin stats
async function loadAdminStats() {
    const result = await apiRequest('stats.php');
    
    if (result.error) return;
    
    const stats = result.data;
    
    // Update stat cards
    const statElements = {
        'admin-total-servers': stats.servers.total_servers,
        'admin-online-servers': stats.servers.online_servers,
        'admin-total-players': stats.servers.total_players,
        'admin-total-mods': stats.mods.total_mods
    };
    
    Object.entries(statElements).forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value || 0;
    });
}

// Load servers table
async function loadServersTable() {
    const tbody = document.querySelector('#servers-table tbody');
    if (!tbody) return;
    
    tbody.innerHTML = '<tr><td colspan="7" class="text-center">جاري التحميل...</td></tr>';
    
    const result = await apiRequest('servers.php?limit=100');
    
    if (result.error) {
        tbody.innerHTML = `<tr><td colspan="7" class="text-center text-error">${result.error}</td></tr>`;
        return;
    }
    
    if (result.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">لا توجد سيرفرات</td></tr>';
        return;
    }
    
    tbody.innerHTML = result.data.map(server => `
        <tr>
            <td>${server.id}</td>
            <td>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <img src="${server.icon_image || '../assets/images/default-icon.jpg'}" alt="" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                    <span>${server.name}</span>
                </div>
            </td>
            <td><span class="badge badge-${server.server_type}">${server.server_type.toUpperCase()}</span></td>
            <td><span class="badge badge-${server.status}">${server.status}</span></td>
            <td>${server.current_players}/${server.max_players}</td>
            <td>${server.rating}</td>
            <td>
                <div class="table-actions">
                    <button class="table-btn edit" onclick="editServer(${server.id})" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="table-btn delete" onclick="deleteServer(${server.id})" title="حذف">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Load mods table
async function loadModsTable() {
    const tbody = document.querySelector('#mods-table tbody');
    if (!tbody) return;
    
    tbody.innerHTML = '<tr><td colspan="7" class="text-center">جاري التحميل...</td></tr>';
    
    const result = await apiRequest('mods.php?limit=100');
    
    if (result.error) {
        tbody.innerHTML = `<tr><td colspan="7" class="text-center text-error">${result.error}</td></tr>`;
        return;
    }
    
    if (result.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">لا توجد مودات</td></tr>';
        return;
    }
    
    tbody.innerHTML = result.data.map(mod => `
        <tr>
            <td>${mod.id}</td>
            <td>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <img src="${mod.preview_image || '../assets/images/default-mod.jpg'}" alt="" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                    <span>${mod.name}</span>
                </div>
            </td>
            <td>${mod.category}</td>
            <td><span class="badge badge-${mod.type}">${mod.type === 'free' ? 'مجاني' : 'مدفوع'}</span></td>
            <td>${mod.price > 0 ? '$' + mod.price : '-'}</td>
            <td>${mod.downloads}</td>
            <td>
                <div class="table-actions">
                    <button class="table-btn edit" onclick="editMod(${mod.id})" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="table-btn delete" onclick="deleteMod(${mod.id})" title="حذف">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Load suggestions table
async function loadSuggestionsTable() {
    const tbody = document.querySelector('#suggestions-table tbody');
    if (!tbody) return;
    
    tbody.innerHTML = '<tr><td colspan="6" class="text-center">جاري التحميل...</td></tr>';
    
    const result = await apiRequest('suggestions.php');
    
    if (result.error) {
        tbody.innerHTML = `<tr><td colspan="6" class="text-center text-error">${result.error}</td></tr>`;
        return;
    }
    
    if (result.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">لا توجد رسائل</td></tr>';
        return;
    }
    
    tbody.innerHTML = result.data.map(suggestion => `
        <tr>
            <td>${suggestion.id}</td>
            <td>${suggestion.name}</td>
            <td>${suggestion.subject}</td>
            <td><span class="badge badge-${suggestion.type}">${getSuggestionTypeLabel(suggestion.type)}</span></td>
            <td><span class="badge badge-${suggestion.status}">${getStatusLabel(suggestion.status)}</span></td>
            <td>
                <div class="table-actions">
                    <button class="table-btn edit" onclick="viewSuggestion(${suggestion.id})" title="عرض">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="table-btn delete" onclick="deleteSuggestion(${suggestion.id})" title="حذف">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function getSuggestionTypeLabel(type) {
    const types = {
        'suggestion': 'اقتراح',
        'complaint': 'شكوى',
        'partnership': 'شراكة',
        'other': 'أخرى'
    };
    return types[type] || type;
}

function getStatusLabel(status) {
    const statuses = {
        'new': 'جديد',
        'read': 'مقروء',
        'replied': 'تم الرد',
        'closed': 'مغلق'
    };
    return statuses[status] || status;
}

// Modal functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
    }
}

// Add/Edit Server
async function editServer(id) {
    const result = await apiRequest('servers.php?id=' + id);
    
    if (result.error) {
        showAlert(result.error, 'error');
        return;
    }
    
    const server = result.data;
    
    // Fill form
    document.getElementById('server-id').value = server.id;
    document.getElementById('server-name').value = server.name;
    document.getElementById('server-description').value = server.description || '';
    document.getElementById('server-ip').value = server.ip_address;
    document.getElementById('server-port').value = server.port;
    document.getElementById('server-discord').value = server.discord_link || '';
    document.getElementById('server-website').value = server.website || '';
    document.getElementById('server-type').value = server.server_type;
    document.getElementById('server-category').value = server.category || '';
    document.getElementById('server-max-players').value = server.max_players;
    document.getElementById('server-status').value = server.status;
    
    openModal('server-modal');
}

async function saveServer() {
    const id = document.getElementById('server-id').value;
    const data = {
        name: document.getElementById('server-name').value,
        description: document.getElementById('server-description').value,
        ip_address: document.getElementById('server-ip').value,
        port: parseInt(document.getElementById('server-port').value),
        discord_link: document.getElementById('server-discord').value,
        website: document.getElementById('server-website').value,
        server_type: document.getElementById('server-type').value,
        category: document.getElementById('server-category').value,
        max_players: parseInt(document.getElementById('server-max-players').value),
        status: document.getElementById('server-status').value
    };
    
    const method = id ? 'PUT' : 'POST';
    if (id) data.id = parseInt(id);
    
    const result = await apiRequest('servers.php', method, data);
    
    if (result.error) {
        showAlert(result.error, 'error');
    } else {
        showAlert(result.message, 'success');
        closeModal('server-modal');
        loadServersTable();
    }
}

async function deleteServer(id) {
    if (!confirm('هل أنت متأكد من حذف هذا السيرفر؟')) return;
    
    const result = await apiRequest('servers.php?id=' + id, 'DELETE');
    
    if (result.error) {
        showAlert(result.error, 'error');
    } else {
        showAlert(result.message, 'success');
        loadServersTable();
    }
}

// Add/Edit Mod
async function editMod(id) {
    const result = await apiRequest('mods.php?id=' + id);
    
    if (result.error) {
        showAlert(result.error, 'error');
        return;
    }
    
    const mod = result.data;
    
    document.getElementById('mod-id').value = mod.id;
    document.getElementById('mod-name').value = mod.name;
    document.getElementById('mod-description').value = mod.description || '';
    document.getElementById('mod-category').value = mod.category;
    document.getElementById('mod-type').value = mod.type;
    document.getElementById('mod-price').value = mod.price;
    document.getElementById('mod-download').value = mod.download_link || '';
    document.getElementById('mod-preview').value = mod.preview_image || '';
    document.getElementById('mod-author').value = mod.author;
    
    openModal('mod-modal');
}

async function saveMod() {
    const id = document.getElementById('mod-id').value;
    const data = {
        name: document.getElementById('mod-name').value,
        description: document.getElementById('mod-description').value,
        category: document.getElementById('mod-category').value,
        type: document.getElementById('mod-type').value,
        price: parseFloat(document.getElementById('mod-price').value),
        download_link: document.getElementById('mod-download').value,
        preview_image: document.getElementById('mod-preview').value,
        author: document.getElementById('mod-author').value
    };
    
    const method = id ? 'PUT' : 'POST';
    if (id) data.id = parseInt(id);
    
    const result = await apiRequest('mods.php', method, data);
    
    if (result.error) {
        showAlert(result.error, 'error');
    } else {
        showAlert(result.message, 'success');
        closeModal('mod-modal');
        loadModsTable();
    }
}

async function deleteMod(id) {
    if (!confirm('هل أنت متأكد من حذف هذا المود؟')) return;
    
    const result = await apiRequest('mods.php?id=' + id, 'DELETE');
    
    if (result.error) {
        showAlert(result.error, 'error');
    } else {
        showAlert(result.message, 'success');
        loadModsTable();
    }
}

// View suggestion
async function viewSuggestion(id) {
    const result = await apiRequest('suggestions.php');
    
    if (result.error) {
        showAlert(result.error, 'error');
        return;
    }
    
    const suggestion = result.data.find(s => s.id == id);
    if (!suggestion) return;
    
    document.getElementById('suggestion-name').textContent = suggestion.name;
    document.getElementById('suggestion-email').textContent = suggestion.email;
    document.getElementById('suggestion-type').textContent = getSuggestionTypeLabel(suggestion.type);
    document.getElementById('suggestion-subject').textContent = suggestion.subject;
    document.getElementById('suggestion-message').textContent = suggestion.message;
    document.getElementById('suggestion-date').textContent = new Date(suggestion.created_at).toLocaleString('ar-SA');
    
    openModal('suggestion-modal');
}

async function deleteSuggestion(id) {
    if (!confirm('هل أنت متأكد من حذف هذه الرسالة؟')) return;
    
    const result = await apiRequest('suggestions.php?id=' + id, 'DELETE');
    
    if (result.error) {
        showAlert(result.error, 'error');
    } else {
        showAlert(result.message, 'success');
        loadSuggestionsTable();
    }
}

// Logout
async function logout() {
    const result = await apiRequest('auth.php', 'POST', { action: 'logout' });
    window.location.href = 'login.html';
}

// Initialize admin panel
document.addEventListener('DOMContentLoaded', async () => {
    // Check auth on admin pages
    if (window.location.pathname.includes('/admin/')) {
        const isAuth = await checkAuth();
        if (!isAuth) return;
        
        // Load data based on page
        const path = window.location.pathname;
        
        if (path.includes('index') || path.includes('dashboard')) {
            loadAdminStats();
            loadServersTable();
        } else if (path.includes('servers')) {
            loadServersTable();
        } else if (path.includes('mods')) {
            loadModsTable();
        } else if (path.includes('suggestions')) {
            loadSuggestionsTable();
        }
    }
});
