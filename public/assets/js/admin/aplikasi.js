/**
 * Aplikasi Pendukung JavaScript
 * Handles interactions for supporting applications page
 */

// Import Bootstrap if not already imported
const bootstrap = window.bootstrap

class AplikasiManager {
  constructor() {
    this.init()
  }

  /**
   * Initialize the application manager
   */
  init() {
    this.setupEventListeners()
    this.setupAnimations()
    this.setupTooltips()
  }

  /**
   * Setup all event listeners
   */
  setupEventListeners() {
    // Download button clicks
    document.addEventListener("click", (e) => {
      if (e.target.classList.contains("btn") && e.target.textContent.includes("Unduh")) {
        this.handleDownload(e)
      }
    })

    // Card hover effects
    document.querySelectorAll(".app-card").forEach((card) => {
      card.addEventListener("mouseenter", () => this.handleCardHover(card, true))
      card.addEventListener("mouseleave", () => this.handleCardHover(card, false))
    })

    // Three dots menu clicks
    document.querySelectorAll(".btn-link").forEach((btn) => {
      if (btn.querySelector(".bi-three-dots")) {
        btn.addEventListener("click", (e) => this.handleMenuClick(e))
      }
    })

    // Copy URL functionality
    document.querySelectorAll(".url-box").forEach((urlBox) => {
      urlBox.addEventListener("click", () => this.copyToClipboard(urlBox))
    })

    // Copy location path functionality
    document.querySelectorAll(".location-box").forEach((locationBox) => {
      locationBox.addEventListener("click", () => this.copyToClipboard(locationBox))
    })
  }

  /**
   * Setup animations for page elements
   */
  setupAnimations() {
    // Animate cards on page load
    const cards = document.querySelectorAll(".app-card")
    cards.forEach((card, index) => {
      card.style.opacity = "0"
      card.style.transform = "translateY(20px)"

      setTimeout(() => {
        card.style.transition = "all 0.5s ease"
        card.style.opacity = "1"
        card.style.transform = "translateY(0)"
      }, index * 100)
    })

    // Animate introduction section
    const introSection = document.querySelector(".container-fluid .bg-white")
    if (introSection) {
      introSection.style.opacity = "0"
      introSection.style.transform = "translateY(-20px)"

      setTimeout(() => {
        introSection.style.transition = "all 0.5s ease"
        introSection.style.opacity = "1"
        introSection.style.transform = "translateY(0)"
      }, 50)
    }
  }

  /**
   * Setup tooltips for interactive elements
   */
  setupTooltips() {
    // Add tooltips to download buttons
    document.querySelectorAll(".btn").forEach((btn) => {
      if (btn.textContent.includes("Unduh")) {
        btn.setAttribute("title", "Klik untuk mengunduh file")
      }
    })

    // Add tooltips to copy-able elements
    document.querySelectorAll(".url-box, .location-box").forEach((box) => {
      box.style.cursor = "pointer"
      box.setAttribute("title", "Klik untuk menyalin")
    })

    // Initialize Bootstrap tooltips if available
    if (bootstrap && bootstrap.Tooltip) {
      document.querySelectorAll("[title]").forEach((element) => {
        new bootstrap.Tooltip(element)
      })
    }
  }

  /**
   * Handle download button clicks
   */
  handleDownload(e) {
    const button = e.target.closest(".btn")
    const originalText = button.innerHTML
    const fileName = this.getFileName(button)

    // Show loading state
    button.disabled = true
    button.innerHTML = '<span class="loading"></span>Mengunduh...'

    // Simulate download process
    setTimeout(() => {
      this.simulateDownload(fileName)
      this.showNotification(`Download ${fileName} dimulai`, "success")

      // Restore button state
      button.disabled = false
      button.innerHTML = originalText
    }, 1500)
  }

  /**
   * Get filename from download card
   */
  getFileName(button) {
    const downloadCard = button.closest(".download-card")
    if (downloadCard) {
      const fileNameElement = downloadCard.querySelector("small")
      return fileNameElement ? fileNameElement.textContent : "file"
    }
    return "file"
  }

  /**
   * Simulate file download
   */
  simulateDownload(fileName) {
    // Create a temporary download link
    const link = document.createElement("a")
    link.href = "#"
    link.download = fileName
    link.style.display = "none"

    document.body.appendChild(link)
    // Note: In a real application, this would trigger an actual download
    // link.click()
    document.body.removeChild(link)
  }

  /**
   * Handle card hover effects
   */
  handleCardHover(card, isHovering) {
    const icon = card.querySelector(".app-icon")
    if (icon) {
      if (isHovering) {
        icon.style.transform = "scale(1.1) rotate(5deg)"
      } else {
        icon.style.transform = "scale(1) rotate(0deg)"
      }
    }
  }

  /**
   * Handle three dots menu clicks
   */
  handleMenuClick(e) {
    e.preventDefault()
    const card = e.target.closest(".app-card")
    const appName = card.querySelector("h5").textContent

    // Create context menu options
    const options = [
      { text: "Lihat Detail", action: () => this.showDetails(appName) },
      { text: "Bagikan", action: () => this.shareApp(appName) },
      { text: "Laporkan Masalah", action: () => this.reportIssue(appName) },
    ]

    this.showContextMenu(e, options)
  }

  /**
   * Show context menu
   */
  showContextMenu(e, options) {
    // Remove existing context menu
    const existingMenu = document.querySelector(".context-menu")
    if (existingMenu) {
      existingMenu.remove()
    }

    // Create context menu
    const menu = document.createElement("div")
    menu.className = "context-menu"
    menu.style.cssText = `
            position: fixed;
            top: ${e.clientY}px;
            left: ${e.clientX}px;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            z-index: 1050;
            min-width: 150px;
            padding: 0.5rem 0;
        `

    options.forEach((option) => {
      const item = document.createElement("div")
      item.className = "context-menu-item"
      item.textContent = option.text
      item.style.cssText = `
                padding: 0.5rem 1rem;
                cursor: pointer;
                font-size: 0.875rem;
                transition: background-color 0.15s ease;
            `

      item.addEventListener("mouseenter", () => {
        item.style.backgroundColor = "#f8f9fa"
      })

      item.addEventListener("mouseleave", () => {
        item.style.backgroundColor = "transparent"
      })

      item.addEventListener("click", () => {
        option.action()
        menu.remove()
      })

      menu.appendChild(item)
    })

    document.body.appendChild(menu)

    // Remove menu when clicking outside
    setTimeout(() => {
      document.addEventListener(
        "click",
        () => {
          menu.remove()
        },
        { once: true },
      )
    }, 100)
  }

  /**
   * Show application details
   */
  showDetails(appName) {
    this.showNotification(`Menampilkan detail untuk ${appName}`, "info")
  }

  /**
   * Share application
   */
  shareApp(appName) {
    if (navigator.share) {
      navigator.share({
        title: appName,
        text: `Aplikasi pendukung INLISLite: ${appName}`,
        url: window.location.href,
      })
    } else {
      // Fallback: copy to clipboard
      this.copyToClipboard(null, `${appName} - ${window.location.href}`)
      this.showNotification("Link disalin ke clipboard", "success")
    }
  }

  /**
   * Report issue
   */
  reportIssue(appName) {
    this.showNotification(`Melaporkan masalah untuk ${appName}`, "warning")
  }

  /**
   * Copy text to clipboard
   */
  copyToClipboard(element, text = null) {
    const textToCopy = text || element.textContent.trim()

    if (navigator.clipboard) {
      navigator.clipboard
        .writeText(textToCopy)
        .then(() => {
          this.showNotification("Disalin ke clipboard", "success")
          this.highlightElement(element)
        })
        .catch(() => {
          this.fallbackCopyToClipboard(textToCopy)
        })
    } else {
      this.fallbackCopyToClipboard(textToCopy)
    }
  }

  /**
   * Fallback copy to clipboard method
   */
  fallbackCopyToClipboard(text) {
    const textArea = document.createElement("textarea")
    textArea.value = text
    textArea.style.position = "fixed"
    textArea.style.left = "-999999px"
    textArea.style.top = "-999999px"
    document.body.appendChild(textArea)
    textArea.focus()
    textArea.select()

    try {
      document.execCommand("copy")
      this.showNotification("Disalin ke clipboard", "success")
    } catch (err) {
      this.showNotification("Gagal menyalin ke clipboard", "error")
    }

    document.body.removeChild(textArea)
  }

  /**
   * Highlight element temporarily
   */
  highlightElement(element) {
    if (!element) return

    const originalBackground = element.style.backgroundColor
    element.style.backgroundColor = "#fff3cd"
    element.style.transition = "background-color 0.3s ease"

    setTimeout(() => {
      element.style.backgroundColor = originalBackground
    }, 1000)
  }

  /**
   * Show notification message
   */
  showNotification(message, type = "info") {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll(".notification")
    existingNotifications.forEach((notification) => notification.remove())

    // Create notification
    const notification = document.createElement("div")
    notification.className = `notification alert alert-${type === "error" ? "danger" : type} alert-dismissible fade show`
    notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1060;
            min-width: 300px;
            max-width: 400px;
        `

    const iconMap = {
      success: "bi-check-circle",
      error: "bi-exclamation-triangle",
      warning: "bi-exclamation-triangle",
      info: "bi-info-circle",
    }

    notification.innerHTML = `
            <i class="bi ${iconMap[type]} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `

    document.body.appendChild(notification)

    // Auto remove after 5 seconds
    setTimeout(() => {
      if (notification.parentNode) {
        notification.remove()
      }
    }, 5000)
  }

  /**
   * Smooth scroll to element
   */
  scrollToElement(element) {
    element.scrollIntoView({
      behavior: "smooth",
      block: "start",
    })
  }

  /**
   * Format file size
   */
  formatFileSize(bytes) {
    if (bytes === 0) return "0 Bytes"

    const k = 1024
    const sizes = ["Bytes", "KB", "MB", "GB"]
    const i = Math.floor(Math.log(bytes) / Math.log(k))

    return Number.parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i]
  }

  /**
   * Debounce function
   */
  debounce(func, wait) {
    let timeout
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout)
        func(...args)
      }
      clearTimeout(timeout)
      timeout = setTimeout(later, wait)
    }
  }
}

// Initialize when document is ready
document.addEventListener("DOMContentLoaded", () => {
  new AplikasiManager()

  // Add some additional UI enhancements
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((tooltip) => {
    if (bootstrap && bootstrap.Tooltip) {
      new bootstrap.Tooltip(tooltip)
    }
  })

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault()
      const target = document.querySelector(this.getAttribute("href"))
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        })
      }
    })
  })
})

// Export for potential external use
window.AplikasiManager = AplikasiManager
