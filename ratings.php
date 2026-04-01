/**
 * ARMAX - FiveM Servers Platform
 * Main JavaScript File
 */

// ============================================
// API Configuration
// ============================================
const API_BASE_URL = 'php/';

// ============================================
// Utility Functions
// ============================================
function $(selector) {
    return document.querySelector(selector);
}

function $$(selector) {
    return document.querySelectorAll(selector);
}

// Format number with commas
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Format rating stars
function formatRating(rating) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    let html = '';
    
    for (let i = 0; i < 5; i++) {
        if (i < fullStars) {
            html += '<i class="fas fa-star"></i>';
        } else if (i === fullStars && hasHalfStar) {
            html += '<i class="fas fa-star-half-alt"></i>';
        } else {
            html += '<i class="far fa-star"></i>';
        }
    }
    
    return html;
}

// Get server type badge
function getServerTypeBadge(type) {
    const types = {
        'esx': { class: 'esx', label: 'ESX' },
        'vrp': { class: 'vrp', label: 'VRP' },
        'cfx': { class: 'cfx', label: 'CFX' },
        'other': { class: 'cfx', label: 'OTHER' }
    };
    
    const t = types[type] || types['other'];
    return `<span class="server-type-badge ${t.class}">${t.label}</span>`;
}

// Show alert
function showAlert(message, type = 'success') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} fade-in`;
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'exclamation-triangle'}"></i>
        <span>${message}</span>
    `;
    
    const container = document.body;
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Copy to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showAlert('تم النسخ إلى الحافظة!', 'success');
    }).catch(() => {
        showAlert('فشل النسخ', 'error');
    });
}

// ============================================
// API Functions
// ============================================
async function apiRequest(endpoint, method = 'GET', data = null) {
    const options = {
        method,
        headers: {
            'Content-Type': 'application/json'
        }
    };
    
    if (data && (method === 'POST' || method === 'PUT')) {
        options.body = JSON.stringify(data);
    }
    
    try {
        const response = await fetch(API_BASE_URL + endpoint, options);
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('API Error:', error);
        return { error: 'Network error' };
    }
}

// ============================================
// Server Functions
// ============================================
async function loadServers(filters = {}) {
    const container = $('#servers-container');
    if (!container) return;
    
    container.innerHTML = '<div class="loading"><div class="spinner"></div></div>';
    
    // Build query string
    const params = new URLSearchParams();
    Object.entries(filters).forEach(([key, value]) => {
        if (value) params.append(key, value);
    });
    
    const result = await apiRequest('servers.php?' + params.toString());
    
    if (result.error) {
        container.innerHTML = `<div class="alert alert-error">${result.error}</div>`;
        return;
    }
    
    if (result.data.length === 0) {
        container.innerHTML = '<div class="text-center" style="padding: 3rem; color: var(--text-secondary);"><i class="fas fa-server" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>لا توجد سيرفرات</div>';
        return;
    }
    
    container.innerHTML = result.data.map(server => createServerCard(server)).join('');
}

function createServerCard(server) {
    return `
        <div class="server-card fade-in" data-id="${server.id}">
            <div class="server-banner">
                <img src="${server.banner_image || 'assets/images/default-banner.jpg'}" alt="${server.name}" loading="lazy">
                ${getServerTypeBadge(server.server_type)}
                <div class="server-status">
                    <span class="status-dot ${server.status}"></span>
                    <span>${server.status === 'online' ? 'متصل' : 'غير متصل'}</span>
                </div>
            </div>
            <div class="server-content">
                <div class="server-header">
                    <div class="server-icon">
                        <img src="${server.icon_image || 'assets/images/default-icon.jpg'}" alt="${server.name}">
                    </div>
                    <div class="server-info">
                        <h3 class="server-name">${server.name}</h3>
                        <p class="server-category">${server.category || 'عام'}</p>
                    </div>
                </div>
                <div class="server-stats-row">
                    <div class="server-stat">
                        <i class="fas fa-users"></i>
                        <span>${server.current_players}/${server.max_players}</span>
                    </div>
                    <div class="server-stat">
                        <i class="fas fa-thumbs-up"></i>
                        <span>${formatNumber(server.votes)} صوت</span>
                    </div>
                </div>
                <p class="server-description">${server.description || 'لا يوجد وصف'}</p>
                <div class="server-footer">
                    <div class="server-rating">
                        ${formatRating(server.rating)}
                        <span class="rating-number">${server.rating}</span>
                    </div>
                    <a href="server-details.html?id=${server.id}" class="btn btn-primary btn-sm">عرض التفاصيل</a>
                </div>
            </div>
        </div>
    `;
}

// ============================================
// Mods Functions
// ============================================
async function loadMods(filters = {}) {
    const container = $('#mods-container');
    if (!container) return;
    
    container.innerHTML = '<div class="loading"><div class="spinner"></div></div>';
    
    const params = new URLSearchParams();
    Object.entries(filters).forEach(([key, value]) => {
        if (value) params.append(key, value);
    });
    
    const result = await apiRequest('mods.php?' + params.toString());
    
    if (result.error) {
        container.innerHTML = `<div class="alert alert-error">${result.error}</div>`;
        return;
    }
    
    if (result.data.length === 0) {
        container.innerHTML = '<div class="text-center" style="padding: 3rem; color: var(--text-secondary);"><i class="fas fa-cube" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>لا توجد مودات</div>';
        return;
    }
    
    container.innerHTML = result.data.map(mod => createModCard(mod)).join('');
}

function createModCard(mod) {
    const priceBadge = mod.type === 'free' 
        ? '<span class="mod-price-badge free">مجاني</span>'
        : `<span class="mod-price-badge paid">$${mod.price}</span>`;
    
    return `
        <div class="mod-card fade-in" data-id="${mod.id}">
            <div class="mod-image">
                <img src="${mod.preview_image || 'assets/images/default-mod.jpg'}" alt="${mod.name}" loading="lazy">
                ${priceBadge}
            </div>
            <div class="mod-content">
                <h3 class="mod-title">${mod.name}</h3>
                <div class="mod-meta">
                    <span><i class="fas fa-user"></i> ${mod.author}</span>
                    <span><i class="fas fa-download"></i> ${formatNumber(mod.downloads)}</span>
                </div>
                <p class="mod-description">${mod.description ? mod.description.substring(0, 100) + '...' : 'لا يوجد وصف'}</p>
                <div class="server-rating" style="margin-bottom: 1rem;">
                    ${formatRating(mod.rating)}
                    <span class="rating-number">${mod.rating}</span>
                </div>
                <a href="mod-details.html?id=${mod.id}" class="btn btn-primary" style="width: 100%;">عرض التفاصيل</a>
            </div>
        </div>
    `;
}

// ============================================
// Search Functionality
// ============================================
function initSearch() {
    const searchInput = $('#search-input');
    if (!searchInput) return;
    
    let debounceTimer;
    searchInput.addEventListener('input', (e) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const query = e.target.value.trim();
            const isServersPage = window.location.pathname.includes('servers');
            
            if (isServersPage) {
                loadServers({ search: query });
            } else {
                loadMods({ search: query });
            }
        }, 300);
    });
}

// ============================================
// Filter Functionality
// ============================================
function initFilters() {
    const filterBtns = $$('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active state
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            // Apply filter
            const filter = btn.dataset.filter;
            const type = btn.dataset.type;
            
            if (type === 'server') {
                loadServers({ type: filter });
            } else if (type === 'mod') {
                loadMods({ category: filter });
            }
        });
    });
}

// ============================================
// Suggestion Form
// ============================================
function initSuggestionForm() {
    const form = $('#suggestion-form');
    if (!form) return;
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        const result = await apiRequest('suggestions.php', 'POST', data);
        
        if (result.error) {
            showAlert(result.error, 'error');
        } else {
            showAlert(result.message, 'success');
            form.reset();
        }
    });
}

// ============================================
// Rating Form
// ============================================
function initRatingForm() {
    const form = $('#rating-form');
    if (!form) return;
    
    // Star rating
    const stars = $$('.star-rating i');
    let selectedRating = 0;
    
    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            selectedRating = index + 1;
            updateStars(selectedRating);
        });
        
        star.addEventListener('mouseenter', () => {
            updateStars(index + 1);
        });
    });
    
    document.querySelector('.star-rating')?.addEventListener('mouseleave', () => {
        updateStars(selectedRating);
    });
    
    function updateStars(rating) {
        stars.forEach((s, i) => {
            s.className = i < rating ? 'fas fa-star' : 'far fa-star';
        });
    }
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        if (selectedRating === 0) {
            showAlert('الرجاء اختيار التقييم', 'error');
            return;
        }
        
        const serverId = form.dataset.serverId;
        const comment = form.querySelector('textarea').value;
        
        const result = await apiRequest('ratings.php', 'POST', {
            action: 'rate',
            server_id: serverId,
            rating: selectedRating,
            comment: comment
        });
        
        if (result.error) {
            showAlert(result.error, 'error');
        } else {
            showAlert(result.message, 'success');
            form.reset();
            selectedRating = 0;
            updateStars(0);
        }
    });
}

// ============================================
// Vote Functionality
// ============================================
async function voteForServer(serverId) {
    const result = await apiRequest('ratings.php', 'POST', {
        action: 'vote',
        server_id: serverId
    });
    
    if (result.error) {
        showAlert(result.error, 'error');
    } else {
        showAlert(result.message, 'success');
    }
}

// ============================================
// Load Server Details
// ============================================
async function loadServerDetails() {
    const urlParams = new URLSearchParams(window.location.search);
    const serverId = urlParams.get('id');
    
    if (!serverId) {
        window.location.href = 'servers.html';
        return;
    }
    
    const result = await apiRequest('servers.php?id=' + serverId);
    
    if (result.error || !result.data) {
        showAlert('السيرفر غير موجود', 'error');
        setTimeout(() => window.location.href = 'servers.html', 2000);
        return;
    }
    
    const server = result.data;
    
    // Update page title
    document.title = `${server.name} - ارموكس`;
    
    // Update details
    const detailsContainer = $('#server-details-container');
    if (detailsContainer) {
        detailsContainer.innerHTML = `
            <div class="details-header">
                <div class="details-container">
                    <div class="details-main">
                        <div class="details-icon">
                            <img src="${server.icon_image || 'assets/images/default-icon.jpg'}" alt="${server.name}">
                        </div>
                        <div class="details-info">
                            <h1 class="details-title">${server.name}</h1>
                            <div class="details-meta">
                                <div class="details-meta-item">
                                    <i class="fas fa-tag"></i>
                                    <span>${server.category || 'عام'}</span>
                                </div>
                                <div class="details-meta-item">
                                    <i class="fas fa-users"></i>
                                    <span>${server.current_players}/${server.max_players} لاعب</span>
                                </div>
                                <div class="details-meta-item">
                                    <span class="status-dot ${server.status}"></span>
                                    <span>${server.status === 'online' ? 'متصل' : 'غير متصل'}</span>
                                </div>
                            </div>
                            <div class="details-actions">
                                <button class="btn btn-primary" onclick="copyToClipboard('${server.ip_address}:${server.port}')">
                                    <i class="fas fa-copy"></i> نسخ IP
                                </button>
                                <a href="${server.discord_link}" target="_blank" class="btn btn-secondary">
                                    <i class="fab fa-discord"></i> ديسكورد
                                </a>
                                <button class="btn btn-outline" onclick="voteForServer(${server.id})">
                                    <i class="fas fa-thumbs-up"></i> تصويت (${server.votes})
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="details-content">
                <div class="details-grid">
                    <div class="details-left">
                        <div class="details-section">
                            <h2 class="details-section-title">
                                <i class="fas fa-info-circle"></i>
                                وصف السيرفر
                            </h2>
                            <p class="details-text">${server.description || 'لا يوجد وصف متاح'}</p>
                        </div>
                        ${server.reviews && server.reviews.length > 0 ? `
                        <div class="details-section">
                            <h2 class="details-section-title">
                                <i class="fas fa-comments"></i>
                                التقييمات والآراء
                            </h2>
                            <div class="reviews-list">
                                ${server.reviews.map(review => `
                                    <div class="info-card">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                            <strong>${review.user_name || 'مستخدم'}</strong>
                                            <span style="color: var(--text-secondary); font-size: 0.85rem;">${new Date(review.created_at).toLocaleDateString('ar-SA')}</span>
                                        </div>
                                        <div class="server-rating" style="margin-bottom: 0.5rem;">
                                            ${formatRating(review.rating || 5)}
                                        </div>
                                        <p style="color: var(--text-secondary);">${review.content}</p>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        ` : ''}
                        <div class="details-section">
                            <h2 class="details-section-title">
                                <i class="fas fa-star"></i>
                                أضف تقييمك
                            </h2>
                            <form id="rating-form" data-server-id="${server.id}">
                                <div class="star-rating" style="font-size: 1.5rem; margin-bottom: 1rem; cursor: pointer;">
                                    <i class="far fa-star" data-rating="1"></i>
                                    <i class="far fa-star" data-rating="2"></i>
                                    <i class="far fa-star" data-rating="3"></i>
                                    <i class="far fa-star" data-rating="4"></i>
                                    <i class="far fa-star" data-rating="5"></i>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-textarea" placeholder="اكتب رأيك هنا..." rows="4"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">إرسال التقييم</button>
                            </form>
                        </div>
                    </div>
                    <div class="details-right">
                        <div class="info-card">
                            <h3 class="info-card-title">معلومات السيرفر</h3>
                            <div class="info-item">
                                <span class="info-label">IP السيرفر</span>
                                <span class="info-value">
                                    ${server.ip_address}:${server.port}
                                    <button class="copy-btn" onclick="copyToClipboard('${server.ip_address}:${server.port}')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">النوع</span>
                                <span class="info-value">${server.server_type.toUpperCase()}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">الفئة</span>
                                <span class="info-value">${server.category || 'عام'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">التقييم</span>
                                <span class="info-value">
                                    ${formatRating(server.rating)}
                                    ${server.rating}
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">عدد التقييمات</span>
                                <span class="info-value">${server.rating_count}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">عدد الأصوات</span>
                                <span class="info-value">${server.votes}</span>
                            </div>
                        </div>
                        <div class="info-card">
                            <h3 class="info-card-title">روابط مهمة</h3>
                            ${server.discord_link ? `
                            <a href="${server.discord_link}" target="_blank" class="btn btn-secondary" style="width: 100%; margin-bottom: 0.5rem;">
                                <i class="fab fa-discord"></i> ديسكورد
                            </a>
                            ` : ''}
                            ${server.website ? `
                            <a href="${server.website}" target="_blank" class="btn btn-secondary" style="width: 100%;">
                                <i class="fas fa-globe"></i> الموقع الرسمي
                            </a>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Initialize rating form
    initRatingForm();
}

// ============================================
// Stats Loading
// ============================================
async function loadStats() {
    const result = await apiRequest('stats.php');
    
    if (result.error) return;
    
    const stats = result.data;
    
    // Update hero stats
    const totalServersEl = $('#stat-total-servers');
    const totalPlayersEl = $('#stat-total-players');
    const totalModsEl = $('#stat-total-mods');
    
    if (totalServersEl) totalServersEl.textContent = stats.servers.total_servers || 0;
    if (totalPlayersEl) totalPlayersEl.textContent = formatNumber(stats.servers.total_players || 0);
    if (totalModsEl) totalModsEl.textContent = stats.mods.total_mods || 0;
}

// ============================================
// Navigation
// ============================================
function initNavigation() {
    const navbar = $('.navbar');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    
    // Mobile menu
    const mobileMenuBtn = $('.mobile-menu-btn');
    const navLinks = $('.nav-links');
    
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    }
}

// ============================================
// Initialize
// ============================================
document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initSearch();
    initFilters();
    initSuggestionForm();
    
    // Load page-specific content
    const path = window.location.pathname;
    
    if (path.includes('servers')) {
        loadServers();
    } else if (path.includes('mods')) {
        loadMods();
    } else if (path.includes('server-details')) {
        loadServerDetails();
    } else if (path === '/' || path.includes('index')) {
        loadStats();
        loadServers({ featured: true, limit: 6 });
        loadMods({ featured: true, limit: 4 });
    }
});
