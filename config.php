/* ============================================
   ARMAX - FiveM Servers Platform
   Main Stylesheet
   ============================================ */

/* CSS Variables */
:root {
    --primary-color: #ff6b35;
    --secondary-color: #1a1a2e;
    --accent-color: #16213e;
    --dark-bg: #0f0f1a;
    --card-bg: #1e1e2d;
    --text-primary: #ffffff;
    --text-secondary: #a0a0b0;
    --success-color: #4ade80;
    --warning-color: #fbbf24;
    --danger-color: #ef4444;
    --info-color: #3b82f6;
    --esx-color: #10b981;
    --vrp-color: #8b5cf6;
    --cfx-color: #3b82f6;
    --gradient-primary: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    --gradient-dark: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    --shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    --shadow-hover: 0 20px 60px rgba(0, 0, 0, 0.4);
    --border-radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Reset & Base */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    font-family: 'Segoe UI', 'Tahoma', 'Geneva', 'Verdana', sans-serif;
    background: var(--dark-bg);
    color: var(--text-primary);
    line-height: 1.6;
    min-height: 100vh;
    direction: rtl;
}

a {
    text-decoration: none;
    color: inherit;
    transition: var(--transition);
}

ul {
    list-style: none;
}

img {
    max-width: 100%;
    height: auto;
}

/* ============================================
   NAVIGATION
   ============================================ */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: rgba(15, 15, 26, 0.95);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    padding: 1rem 0;
    transition: var(--transition);
}

.navbar.scrolled {
    padding: 0.7rem 0;
    background: rgba(15, 15, 26, 0.98);
}

.nav-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.75rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.logo-icon {
    width: 45px;
    height: 45px;
    background: var(--gradient-primary);
    border-radius: var(--border-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    -webkit-text-fill-color: white;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 2.5rem;
}

.nav-links a {
    color: var(--text-secondary);
    font-weight: 500;
    font-size: 1rem;
    position: relative;
    padding: 0.5rem 0;
}

.nav-links a::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: 0;
    width: 0;
    height: 2px;
    background: var(--gradient-primary);
    transition: var(--transition);
}

.nav-links a:hover,
.nav-links a.active {
    color: var(--text-primary);
}

.nav-links a:hover::after,
.nav-links a.active::after {
    width: 100%;
}

.nav-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius);
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: var(--transition);
    border: none;
    outline: none;
}

.btn-primary {
    background: var(--gradient-primary);
    color: white;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.05);
    color: var(--text-primary);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
}

.btn-outline {
    background: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
}

.btn-outline:hover {
    background: var(--primary-color);
    color: white;
}

.mobile-menu-btn {
    display: none;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
    padding: 5px;
}

.mobile-menu-btn span {
    width: 25px;
    height: 2px;
    background: var(--text-primary);
    transition: var(--transition);
}

/* ============================================
   HERO SECTION
   ============================================ */
.hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 8rem 2rem 4rem;
    background: var(--dark-bg);
    overflow: hidden;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(ellipse at 20% 80%, rgba(255, 107, 53, 0.15) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
        radial-gradient(ellipse at 50% 50%, rgba(59, 130, 246, 0.05) 0%, transparent 70%);
    pointer-events: none;
}

.hero-content {
    text-align: center;
    max-width: 900px;
    position: relative;
    z-index: 1;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(255, 107, 53, 0.1);
    border: 1px solid rgba(255, 107, 53, 0.2);
    border-radius: 50px;
    font-size: 0.875rem;
    color: var(--primary-color);
    margin-bottom: 1.5rem;
}

.hero-title {
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1.5rem;
}

.hero-title span {
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.25rem;
    color: var(--text-secondary);
    margin-bottom: 2.5rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 4rem;
    margin-bottom: 3rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* ============================================
   SEARCH SECTION
   ============================================ */
.search-section {
    padding: 3rem 2rem;
    background: var(--secondary-color);
    position: relative;
}

.search-container {
    max-width: 800px;
    margin: 0 auto;
}

.search-box {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    width: 100%;
    padding: 1.25rem 1.5rem;
    padding-left: 4rem;
    background: var(--card-bg);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--border-radius);
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
}

.search-input::placeholder {
    color: var(--text-secondary);
}

.search-btn {
    position: absolute;
    left: 0.5rem;
    top: 50%;
    transform: translateY(-50%);
    width: 45px;
    height: 45px;
    background: var(--gradient-primary);
    border: none;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.search-btn:hover {
    transform: translateY(-50%) scale(1.05);
}

/* ============================================
   SECTIONS
   ============================================ */
.section {
    padding: 5rem 2rem;
}

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
}

.section-title span {
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-subtitle {
    color: var(--text-secondary);
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
}

/* ============================================
   SERVER CARDS
   ============================================ */
.servers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.server-card {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: var(--transition);
    position: relative;
}

.server-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
    border-color: rgba(255, 107, 53, 0.2);
}

.server-banner {
    height: 150px;
    background: var(--gradient-dark);
    position: relative;
    overflow: hidden;
}

.server-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.server-type-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}

.server-type-badge.esx {
    background: rgba(16, 185, 129, 0.2);
    color: var(--esx-color);
}

.server-type-badge.vrp {
    background: rgba(139, 92, 246, 0.2);
    color: var(--vrp-color);
}

.server-type-badge.cfx {
    background: rgba(59, 130, 246, 0.2);
    color: var(--cfx-color);
}

.server-status {
    position: absolute;
    top: 1rem;
    left: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.35rem 0.75rem;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 50px;
    font-size: 0.75rem;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.status-dot.online {
    background: var(--success-color);
}

.status-dot.offline {
    background: var(--danger-color);
    animation: none;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.server-content {
    padding: 1.5rem;
}

.server-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
}

.server-icon {
    width: 60px;
    height: 60px;
    border-radius: var(--border-radius);
    overflow: hidden;
    flex-shrink: 0;
    border: 2px solid rgba(255, 255, 255, 0.1);
}

.server-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.server-info {
    flex: 1;
}

.server-name {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.server-category {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.server-stats-row {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.server-stat {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.server-stat i {
    color: var(--primary-color);
}

.server-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.server-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.server-rating {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.server-rating i {
    color: var(--warning-color);
    font-size: 0.875rem;
}

.rating-number {
    margin-right: 0.5rem;
    font-weight: 600;
}

/* ============================================
   FILTERS
   ============================================ */
.filters-section {
    padding: 2rem;
    background: var(--secondary-color);
}

.filters-container {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: center;
    justify-content: center;
}

.filter-btn {
    padding: 0.6rem 1.25rem;
    background: var(--card-bg);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 50px;
    color: var(--text-secondary);
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* ============================================
   MODS SECTION
   ============================================ */
.mods-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.mod-card {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: var(--transition);
}

.mod-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.mod-image {
    height: 180px;
    background: var(--gradient-dark);
    position: relative;
    overflow: hidden;
}

.mod-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.mod-card:hover .mod-image img {
    transform: scale(1.05);
}

.mod-price-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
}

.mod-price-badge.free {
    background: rgba(74, 222, 128, 0.2);
    color: var(--success-color);
}

.mod-price-badge.paid {
    background: rgba(255, 107, 53, 0.2);
    color: var(--primary-color);
}

.mod-content {
    padding: 1.5rem;
}

.mod-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.mod-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    color: var(--text-secondary);
    font-size: 0.85rem;
    margin-bottom: 1rem;
}

.mod-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

/* ============================================
   SERVER DETAILS PAGE
   ============================================ */
.server-details {
    padding-top: 100px;
    min-height: 100vh;
}

.details-header {
    background: var(--gradient-dark);
    padding: 3rem 2rem;
    position: relative;
}

.details-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.03)"/></svg>');
    background-size: 50px 50px;
}

.details-container {
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.details-main {
    display: flex;
    gap: 2rem;
    align-items: flex-start;
}

.details-icon {
    width: 120px;
    height: 120px;
    border-radius: var(--border-radius);
    overflow: hidden;
    border: 3px solid rgba(255, 255, 255, 0.1);
    flex-shrink: 0;
}

.details-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.details-info {
    flex: 1;
}

.details-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.details-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.details-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
}

.details-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.details-content {
    padding: 3rem 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.details-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
}

.details-section {
    margin-bottom: 2rem;
}

.details-section-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.details-section-title i {
    color: var(--primary-color);
}

.details-text {
    color: var(--text-secondary);
    line-height: 1.8;
}

.info-card {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.info-card-title {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.info-value {
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.copy-btn {
    background: none;
    border: none;
    color: var(--primary-color);
    cursor: pointer;
    padding: 0.25rem;
    transition: var(--transition);
}

.copy-btn:hover {
    color: var(--text-primary);
}

/* ============================================
   FORMS
   ============================================ */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-primary);
}

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 1rem;
    background: var(--card-bg);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--border-radius);
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
}

.form-textarea {
    min-height: 150px;
    resize: vertical;
}

.form-select {
    cursor: pointer;
}

/* ============================================
   FOOTER
   ============================================ */
.footer {
    background: var(--secondary-color);
    padding: 4rem 2rem 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

.footer-container {
    max-width: 1400px;
    margin: 0 auto;
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 3rem;
    margin-bottom: 3rem;
}

.footer-brand {
    max-width: 300px;
}

.footer-logo {
    font-size: 2rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
    display: inline-block;
}

.footer-description {
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: 1.5rem;
}

.footer-social {
    display: flex;
    gap: 1rem;
}

.footer-social a {
    width: 40px;
    height: 40px;
    background: var(--card-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    transition: var(--transition);
}

.footer-social a:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-3px);
}

.footer-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.footer-links li {
    margin-bottom: 0.75rem;
}

.footer-links a {
    color: var(--text-secondary);
    transition: var(--transition);
}

.footer-links a:hover {
    color: var(--primary-color);
    padding-right: 0.5rem;
}

.footer-bottom {
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    text-align: center;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

/* ============================================
   ADMIN PANEL
   ============================================ */
.admin-body {
    display: flex;
    min-height: 100vh;
}

.admin-sidebar {
    width: 280px;
    background: var(--secondary-color);
    border-left: 1px solid rgba(255, 255, 255, 0.05);
    position: fixed;
    right: 0;
    top: 0;
    bottom: 0;
    overflow-y: auto;
    z-index: 100;
}

.admin-logo {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    font-size: 1.5rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.admin-nav {
    padding: 1rem 0;
}

.admin-nav-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    color: var(--text-secondary);
    transition: var(--transition);
    border-right: 3px solid transparent;
}

.admin-nav-item:hover,
.admin-nav-item.active {
    background: rgba(255, 107, 53, 0.1);
    color: var(--text-primary);
    border-right-color: var(--primary-color);
}

.admin-nav-item i {
    width: 20px;
    text-align: center;
}

.admin-main {
    flex: 1;
    margin-right: 280px;
    padding: 2rem;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.admin-title {
    font-size: 1.75rem;
    font-weight: 700;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.stat-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.stat-card-title {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.stat-card-icon {
    width: 45px;
    height: 45px;
    background: rgba(255, 107, 53, 0.1);
    border-radius: var(--border-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
}

.stat-card-value {
    font-size: 2rem;
    font-weight: 800;
}

.data-table {
    width: 100%;
    background: var(--card-bg);
    border-radius: var(--border-radius);
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.data-table table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 1rem;
    text-align: right;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.data-table th {
    background: rgba(255, 255, 255, 0.02);
    font-weight: 600;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.data-table tr:hover {
    background: rgba(255, 255, 255, 0.02);
}

.table-actions {
    display: flex;
    gap: 0.5rem;
}

.table-btn {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.table-btn.edit {
    background: rgba(59, 130, 246, 0.1);
    color: var(--info-color);
}

.table-btn.delete {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger-color);
}

.table-btn:hover {
    transform: scale(1.1);
}

/* ============================================
   MODAL
   ============================================ */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    transform: scale(0.9) translateY(20px);
    transition: var(--transition);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.modal-overlay.active .modal {
    transform: scale(1) translateY(0);
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 700;
}

.modal-close {
    background: none;
    border: none;
    color: var(--text-secondary);
    font-size: 1.5rem;
    cursor: pointer;
    transition: var(--transition);
}

.modal-close:hover {
    color: var(--text-primary);
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

/* ============================================
   ALERTS
   ============================================ */
.alert {
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-success {
    background: rgba(74, 222, 128, 0.1);
    border: 1px solid rgba(74, 222, 128, 0.2);
    color: var(--success-color);
}

.alert-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: var(--danger-color);
}

.alert-warning {
    background: rgba(251, 191, 36, 0.1);
    border: 1px solid rgba(251, 191, 36, 0.2);
    color: var(--warning-color);
}

/* ============================================
   LOADING
   ============================================ */
.loading {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 3px solid rgba(255, 255, 255, 0.1);
    border-top-color: var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 1024px) {
    .details-grid {
        grid-template-columns: 1fr;
    }
    
    .admin-sidebar {
        transform: translateX(100%);
        transition: transform 0.3s ease;
    }
    
    .admin-sidebar.active {
        transform: translateX(0);
    }
    
    .admin-main {
        margin-right: 0;
    }
}

@media (max-width: 768px) {
    .nav-links,
    .nav-actions .btn-secondary {
        display: none;
    }
    
    .mobile-menu-btn {
        display: flex;
    }
    
    .hero-stats {
        gap: 2rem;
    }
    
    .servers-grid {
        grid-template-columns: 1fr;
    }
    
    .details-main {
        flex-direction: column;
        text-align: center;
    }
    
    .details-icon {
        margin: 0 auto;
    }
    
    .details-actions {
        justify-content: center;
    }
    
    .footer-grid {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .footer-brand {
        max-width: 100%;
    }
    
    .footer-social {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 1.75rem;
    }
    
    .btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
    }
}

/* ============================================
   ANIMATIONS
   ============================================ */
.fade-in {
    animation: fadeIn 0.5s ease forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.slide-in-right {
    animation: slideInRight 0.5s ease forwards;
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: var(--dark-bg);
}

::-webkit-scrollbar-thumb {
    background: var(--card-bg);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--primary-color);
}
