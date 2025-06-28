/**
 * Dashboard JavaScript
 * Handles dashboard interactions and navigation
 */

class DashboardManager {
  constructor() {
    this.init()
  }

  /**
   * Initialize dashboard functionality
   */
  init() {
    this.setupEventListeners()
    this.setupDarkMode()
    this.setupMobileMenu()
    this.setupCardNavigation()
  }

  /**
   * Setup all event listeners
   */
  setupEventListeners() {
    // Dark mode toggle
    const darkModeSwitch = document.getElementById("darkModeSwitch")
    if (darkModeSwitch) {
      darkModeSwitch.addEventListener("change", () => this.toggleDarkMode())
    }

    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById("mobile-menu-toggle")
    if (mobileMenuToggle) {
      mobileMenuToggle.addEventListener("click", () => this.toggleMobileMenu())
    }

    // Card click navigation
    document.querySelectorAll(".module-card").forEach((card) => {
      card.addEventListener("click", (e) => this.handleCardClick(e))
    })

    // Prevent card link clicks from bubbling
    document.querySelectorAll(".card-link").forEach((link) => {
      link.addEventListener("click", (e) => {
        e.stopPropagation()
      })
    })
  }

  /**
   * Setup card navigation functionality
   */
  setupCardNavigation() {
    // Add hover effects to clickable cards
    document.querySelectorAll(".module-card[data-url]").forEach((card) => {
      const url = card.getAttribute("data-url")

      // Only add hover effects to cards with valid URLs
      if (url && url !== "#") {
        card.classList.add("clickable-card")

        // Add hover effect
        card.addEventListener("mouseenter", () => {
          card.style.transform = "translateY(-5px)"
          card.style.boxShadow = "0 8px 25px rgba(0,0,0,0.15)"
        })

        card.addEventListener("mouseleave", () => {
          card.style.transform = "translateY(0)"
          card.style.boxShadow = ""
        })
      }
    })
  }

  /**
   * Handle card click events
   */
  handleCardClick(e) {
    // Prevent navigation if clicking on a link
    if (e.target.tagName === "A" || e.target.closest("a")) {
      return
    }

    const card = e.currentTarget
    const url = card.getAttribute("data-url")
    const cardId = card.getAttribute("id")

    if (!url || url === "#") {
      return
    }

    // Add click animation
    this.animateCardClick(card)

    // Navigate based on card type
    setTimeout(() => {
      this.navigateToPage(url, cardId)
    }, 150)
  }

  /**
   * Animate card click
   */
  animateCardClick(card) {
    card.style.transform = "scale(0.98)"
    card.style.transition = "transform 0.1s ease"

    setTimeout(() => {
      card.style.transform = ""
      card.style.transition = ""
    }, 100)
  }

  /**
   * Navigate to specific page
   */
  navigateToPage(url, cardId) {
    // Show loading indicator for specific cards
    if (cardId === "patch-updater" || cardId === "aplikasi-pendukung") {
      this.showLoadingIndicator(`Memuat ${cardId === "patch-updater" ? "Patch Updater" : "Aplikasi Pendukung"}...`)
    }

    // Navigate to the URL
    window.location.href = url
  }

  /**
   * Show loading indicator
   */
  showLoadingIndicator(message) {
    // Remove existing loading indicator
    const existingLoader = document.querySelector(".loading-indicator")
    if (existingLoader) {
      existingLoader.remove()
    }

    // Create loading indicator
    const loader = document.createElement("div")
    loader.className = "loading-indicator"
    loader.innerHTML = `
            <div class="loading-backdrop">
                <div class="loading-content">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 mb-0">${message}</p>
                </div>
            </div>
        `

    // Add styles
    loader.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        `

    const backdrop = loader.querySelector(".loading-backdrop")
    backdrop.style.cssText = `
            background: rgba(255, 255, 255, 0.9);
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(2px);
        `

    const content = loader.querySelector(".loading-content")
    content.style.cssText = `
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        `

    document.body.appendChild(loader)

    // Auto remove after 5 seconds (fallback)
    setTimeout(() => {
      if (loader.parentNode) {
        loader.remove()
      }
    }, 5000)
  }

  /**
   * Setup dark mode functionality
   */
  setupDarkMode() {
    const darkModeSwitch = document.getElementById("darkModeSwitch")
    const savedTheme = localStorage.getItem("theme")

    // Apply saved theme
    if (savedTheme) {
      document.documentElement.setAttribute("data-bs-theme", savedTheme)
      if (darkModeSwitch) {
        darkModeSwitch.checked = savedTheme === "dark"
      }
    }
  }

  /**
   * Toggle dark mode
   */
  toggleDarkMode() {
    const darkModeSwitch = document.getElementById("darkModeSwitch")
    const currentTheme = document.documentElement.getAttribute("data-bs-theme")
    const newTheme = currentTheme === "dark" ? "light" : "dark"

    document.documentElement.setAttribute("data-bs-theme", newTheme)
    localStorage.setItem("theme", newTheme)

    // Show notification
    this.showNotification(`Mode ${newTheme === "dark" ? "gelap" : "terang"} diaktifkan`, "success")
  }

  /**
   * Setup mobile menu functionality
   */
  setupMobileMenu() {
    // This would integrate with your sidebar component
    // Implementation depends on your sidebar structure
  }

  /**
   * Toggle mobile menu
   */
  toggleMobileMenu() {
    const sidebar = document.getElementById("sidebar-wrapper")
    if (sidebar) {
      sidebar.classList.toggle("show")
    }
  }

  /**
   * Show notification
   */
  showNotification(message, type = "info") {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll(".dashboard-notification")
    existingNotifications.forEach((notification) => notification.remove())

    // Create notification
    const notification = document.createElement("div")
    notification.className = `dashboard-notification alert alert-${type} alert-dismissible fade show`
    notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1060;
            min-width: 300px;
            max-width: 400px;
        `

    const iconMap = {
      success: "fa-check-circle",
      error: "fa-exclamation-triangle",
      warning: "fa-exclamation-triangle",
      info: "fa-info-circle",
    }

    notification.innerHTML = `
            <i class="fa-solid ${iconMap[type]} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `

    document.body.appendChild(notification)

    // Auto remove after 3 seconds
    setTimeout(() => {
      if (notification.parentNode) {
        notification.remove()
      }
    }, 3000)
  }

  /**
   * Add card statistics or dynamic content
   */
  updateCardStats() {
    // This could be used to update card content dynamically
    // For example, showing real-time statistics
  }

  /**
   * Handle keyboard navigation
   */
  setupKeyboardNavigation() {
    document.addEventListener("keydown", (e) => {
      // ESC key to close any open modals or overlays
      if (e.key === "Escape") {
        const loader = document.querySelector(".loading-indicator")
        if (loader) {
          loader.remove()
        }
      }
    })
  }
}

// Initialize dashboard when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  new DashboardManager()
})

// Export for potential external use
window.DashboardManager = DashboardManager
