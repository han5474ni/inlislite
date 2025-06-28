// JavaScript for INLISLite Tentang Page

document.addEventListener("DOMContentLoaded", () => {
  // Initialize page functionality
  initAnimations()
  initSmoothScrolling()

  console.log("INLISLite Tentang Page loaded successfully")
})

// Initialize Animations
function initAnimations() {
  // Add fade-in animation to cards when they come into view
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("fade-in")
        observer.unobserve(entry.target)
      }
    })
  }, observerOptions)

  // Observe all cards and sections
  const animatedElements = document.querySelectorAll(".card, .feature-card")
  animatedElements.forEach((element) => {
    observer.observe(element)
  })
}

// Smooth Scrolling for anchor links
function initSmoothScrolling() {
  const anchorLinks = document.querySelectorAll('a[href^="#"]')

  anchorLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault()

      const targetId = this.getAttribute("href").substring(1)
      const targetElement = document.getElementById(targetId)

      if (targetElement) {
        const offsetTop = targetElement.offsetTop - 100 // Account for fixed header

        window.scrollTo({
          top: offsetTop,
          behavior: "smooth",
        })
      }
    })
  })
}

// Print Functionality
function printPage() {
  window.print()
}

// Copy to Clipboard Functionality
function copyToClipboard(text) {
  if (navigator.clipboard && window.isSecureContext) {
    navigator.clipboard
      .writeText(text)
      .then(() => {
        showNotification("Teks berhasil disalin!", "success")
      })
      .catch((err) => {
        console.error("Failed to copy text: ", err)
        showNotification("Gagal menyalin teks", "error")
      })
  } else {
    // Fallback for older browsers
    const textArea = document.createElement("textarea")
    textArea.value = text
    document.body.appendChild(textArea)
    textArea.focus()
    textArea.select()

    try {
      document.execCommand("copy")
      showNotification("Teks berhasil disalin!", "success")
    } catch (err) {
      console.error("Failed to copy text: ", err)
      showNotification("Gagal menyalin teks", "error")
    }

    document.body.removeChild(textArea)
  }
}

// Show Notification
function showNotification(message, type = "info") {
  // Create notification element
  const notification = document.createElement("div")
  notification.className = `alert alert-${type === "error" ? "danger" : type} alert-dismissible fade show position-fixed`
  notification.style.cssText = "top: 20px; right: 20px; z-index: 9999; min-width: 300px;"
  notification.innerHTML = `
        ${message}
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

// Export functions for global access
window.printPage = printPage
window.copyToClipboard = copyToClipboard
