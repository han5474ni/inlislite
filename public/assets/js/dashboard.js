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
    this.restoreSidebarState()
    this.debugElements() // Add debug check
    this.setupDebugButton() // Add debug button functionality
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
    this.setupSidebarToggle()
    this.setupOverlayClick()
    this.setupKeyboardNavigation()
    this.handleWindowResize()
  }

  /**
   * Setup sidebar toggle functionality
   */
  setupSidebarToggle() {
    // Desktop collapse toggle
    const desktopToggle = document.getElementById("menu-toggle")
    if (desktopToggle) {
      desktopToggle.addEventListener("click", () => this.toggleDesktopSidebar())
    }

    // Mobile menu toggle
    const mobileToggle = document.getElementById("mobile-menu-toggle")
    if (mobileToggle) {
      mobileToggle.addEventListener("click", (e) => {
        e.preventDefault()
        console.log('Mobile menu toggle clicked') // Debug logging
        this.toggleMobileSidebar()
      })
    } else {
      console.warn('Mobile menu toggle button not found')
    }

    // Mobile close button
    const sidebarClose = document.getElementById("sidebar-close")
    if (sidebarClose) {
      sidebarClose.addEventListener("click", () => this.closeMobileSidebar())
    }
  }

  /**
   * Setup overlay click to close sidebar
   */
  setupOverlayClick() {
    const overlay = document.getElementById("sidebar-overlay")
    if (overlay) {
      overlay.addEventListener("click", () => this.closeMobileSidebar())
    }
  }

  /**
   * Handle window resize
   */
  handleWindowResize() {
    window.addEventListener("resize", () => {
      if (window.innerWidth >= 768) {
        // Desktop - remove mobile classes
        document.body.classList.remove("sidebar-mobile-open")
      } else {
        // Mobile - remove desktop classes
        document.body.classList.remove("sidebar-collapsed")
      }
    })
  }

  /**
   * Toggle desktop sidebar (collapse/expand)
   */
  toggleDesktopSidebar() {
    document.body.classList.toggle("sidebar-collapsed")
    
    // Save state to localStorage
    const isCollapsed = document.body.classList.contains("sidebar-collapsed")
    localStorage.setItem("sidebar-collapsed", isCollapsed)
  }

  /**
   * Toggle mobile sidebar (show/hide)
   */
  toggleMobileSidebar() {
    const isOpen = document.body.classList.contains("sidebar-mobile-open")
    console.log('Toggling mobile sidebar. Currently open:', isOpen) // Debug logging
    
    if (isOpen) {
      this.closeMobileSidebar()
    } else {
      this.openMobileSidebar()
    }
  }

  /**
   * Open mobile sidebar
   */
  openMobileSidebar() {
    console.log('Opening mobile sidebar') // Debug logging
    document.body.classList.add("sidebar-mobile-open")
    document.body.style.overflow = "hidden" // Prevent body scroll
    
    // Add animation delay for better UX
    setTimeout(() => {
      const sidebar = document.getElementById("sidebar-wrapper")
      if (sidebar) {
        sidebar.style.transform = "translateX(0)"
      }
    }, 10)
  }

  /**
   * Close mobile sidebar
   */
  closeMobileSidebar() {
    console.log('Closing mobile sidebar') // Debug logging
    document.body.classList.remove("sidebar-mobile-open")
    document.body.style.overflow = "" // Restore body scroll
    
    // Reset sidebar position
    const sidebar = document.getElementById("sidebar-wrapper")
    if (sidebar) {
      sidebar.style.transform = ""
    }
  }

  /**
   * Toggle mobile menu (legacy method for compatibility)
   */
  toggleMobileMenu() {
    this.toggleMobileSidebar()
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
      // ESC key to close sidebar on mobile or any open modals
      if (e.key === "Escape") {
        // Close mobile sidebar if open
        if (document.body.classList.contains("sidebar-mobile-open")) {
          this.closeMobileSidebar()
          return
        }
        
        // Close loading indicator
        const loader = document.querySelector(".loading-indicator")
        if (loader) {
          loader.remove()
        }
      }
      
      // Ctrl/Cmd + B to toggle sidebar
      if ((e.ctrlKey || e.metaKey) && e.key === "b") {
        e.preventDefault()
        if (window.innerWidth >= 768) {
          this.toggleDesktopSidebar()
        } else {
          this.toggleMobileSidebar()
        }
      }
    })
  }

  /**
   * Restore sidebar state from localStorage
   */
  restoreSidebarState() {
    // Only restore desktop sidebar state on desktop
    if (window.innerWidth >= 768) {
      const isCollapsed = localStorage.getItem("sidebar-collapsed") === "true"
      if (isCollapsed) {
        document.body.classList.add("sidebar-collapsed")
      }
    }
  }

  /**
   * Debug function to check if all elements exist
   */
  debugElements() {
    const elements = {
      'mobile-menu-toggle': document.getElementById("mobile-menu-toggle"),
      'sidebar-wrapper': document.getElementById("sidebar-wrapper"),
      'sidebar-overlay': document.getElementById("sidebar-overlay"),
      'sidebar-close': document.getElementById("sidebar-close"),
      'menu-toggle': document.getElementById("menu-toggle")
    }

    console.log('=== Dashboard Elements Debug ===')
    for (const [name, element] of Object.entries(elements)) {
      if (element) {
        console.log(`✓ ${name}: Found`)
      } else {
        console.warn(`✗ ${name}: Not found`)
      }
    }

    // Check if we're on mobile
    const isMobile = window.innerWidth < 768
    console.log(`Screen width: ${window.innerWidth}px (Mobile: ${isMobile})`)
    
    // Check current classes
    console.log('Body classes:', document.body.classList.toString())
  }

  /**
   * Setup debug button for mobile testing
   */
  setupDebugButton() {
    const debugBtn = document.getElementById("debugMobileBtn")
    if (debugBtn && window.innerWidth < 768) {
      // Show debug button on mobile
      debugBtn.style.display = 'block'
      
      debugBtn.addEventListener('click', () => {
        console.log('=== MOBILE DEBUG TEST ===')
        this.debugElements()
        
        // Test mobile sidebar toggle
        console.log('Testing mobile sidebar toggle...')
        this.toggleMobileSidebar()
      })
    }
  }
}

// Initialize dashboard when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  new DashboardManager()
})

// Export for potential external use
window.DashboardManager = DashboardManager
