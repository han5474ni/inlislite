/**
 * Patch Manager JavaScript - Table Layout Version
 * Handles all CRUD operations for patch management system
 */

class PatchManager {
  constructor() {
    this.baseUrl = window.patchConfig.baseUrl
    this.csrfToken = window.patchConfig.csrfToken
    this.csrfHash = window.patchConfig.csrfHash
    this.init()
  }

  /**
   * Initialize the patch manager
   */
  init() {
    this.setupEventListeners()
    this.setupSearchAndFilter()
    this.setDefaultDate()
  }

  /**
   * Setup all event listeners
   */
  setupEventListeners() {
    // Form submissions
    document.getElementById("addPatchForm").addEventListener("submit", (e) => this.handleFormSubmit(e, "create"))
    document.getElementById("editPatchForm").addEventListener("submit", (e) => this.handleFormSubmit(e, "update"))

    // Action buttons
    document.addEventListener("click", (e) => {
      if (e.target.classList.contains("btn-edit")) {
        this.handleEdit(e)
      } else if (e.target.classList.contains("btn-delete")) {
        this.handleDelete(e)
      } else if (e.target.classList.contains("btn-download")) {
        this.handleDownload(e)
      }
    })

    // Modal events
    document.getElementById("addPatchModal").addEventListener("hidden.bs.modal", () => this.resetForm("#addPatchForm"))
    document
      .getElementById("editPatchModal")
      .addEventListener("hidden.bs.modal", () => this.resetForm("#editPatchForm"))

    // Form validation
    document.querySelectorAll("form").forEach((form) => {
      form.addEventListener("input", (e) => this.validateField(e.target))
      form.addEventListener("change", (e) => this.validateField(e.target))
    })
  }

  /**
   * Setup search and filter functionality
   */
  setupSearchAndFilter() {
    document.getElementById("searchInput").addEventListener(
      "input",
      this.debounce(() => this.filterPatches(), 300),
    )
    document.getElementById("priorityFilter").addEventListener("change", () => this.filterPatches())
  }

  /**
   * Set default date to today
   */
  setDefaultDate() {
    const today = new Date().toISOString().split("T")[0]
    document.getElementById("tanggal_rilis").value = today
  }

  /**
   * Filter patches based on search and priority
   */
  filterPatches() {
    const searchTerm = document.getElementById("searchInput").value.toLowerCase().trim()
    const selectedPriority = document.getElementById("priorityFilter").value

    document.querySelectorAll(".patch-row").forEach((row) => {
      const patchName = row.querySelector(".patch-details h6").textContent.toLowerCase()
      const patchDesc = row.querySelector(".patch-details p").textContent.toLowerCase()
      const patchPriority = row.getAttribute("data-priority")

      const matchesSearch = !searchTerm || patchName.includes(searchTerm) || patchDesc.includes(searchTerm)
      const matchesPriority = !selectedPriority || patchPriority === selectedPriority

      row.style.display = matchesSearch && matchesPriority ? "" : "none"
    })

    this.updateResultsCount()
  }

  /**
   * Update the results count display
   */
  updateResultsCount() {
    const visibleCount = document.querySelectorAll(".patch-row:visible").length
    document.getElementById("patchCount").textContent = visibleCount
  }

  /**
   * Handle form submission for create/update
   */
  async handleFormSubmit(e, action) {
    e.preventDefault()

    const form = e.target
    const submitBtn = form.querySelector('button[type="submit"]')
    const originalText = submitBtn.innerHTML

    // Validate form before submission
    if (!this.validateForm(form)) {
      this.showNotification("Mohon periksa kembali data yang diisi", "error")
      return
    }

    try {
      this.setButtonLoading(submitBtn, true)

      const formData = new FormData(form)
      formData.append("action", action)
      formData.append(this.csrfToken, this.csrfHash)

      const response = await fetch(this.baseUrl, {
        method: "POST",
        body: formData,
      })

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }

      const result = await response.json()

      if (result.success) {
        const message = action === "create" ? "Patch berhasil ditambahkan!" : "Patch berhasil diupdate!"

        this.showNotification(message, "success")

        // Close modal and reload page after short delay
        form.closest(".modal").classList.remove("show")
        setTimeout(() => location.reload(), 1000)
      } else {
        throw new Error(result.error || "Unknown error occurred")
      }
    } catch (error) {
      console.error("Form submission error:", error)
      this.showNotification(`Error: ${error.message}`, "error")
    } finally {
      this.setButtonLoading(submitBtn, false, originalText)
    }
  }

  /**
   * Handle edit button click
   */
  async handleEdit(e) {
    const id = e.target.closest("button").dataset.id

    if (!id) {
      this.showNotification("ID patch tidak valid", "error")
      return
    }

    try {
      const response = await fetch(this.baseUrl, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=get&id=${id}&${this.csrfToken}=${this.csrfHash}`,
      })

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }

      const result = await response.json()

      if (result.success && result.data) {
        this.populateEditForm(result.data)
        document.getElementById("editPatchModal").classList.add("show")
      } else {
        throw new Error(result.error || "Data patch tidak ditemukan")
      }
    } catch (error) {
      console.error("Edit error:", error)
      this.showNotification(error.message, "error")
    }
  }

  /**
   * Handle delete button click
   */
  async handleDelete(e) {
    const btn = e.target.closest("button")
    const id = btn.dataset.id
    const patchName = btn.closest("tr").querySelector(".patch-details h6").textContent

    if (!id) {
      this.showNotification("ID patch tidak valid", "error")
      return
    }

    // Confirm deletion
    if (!confirm(`Apakah Anda yakin ingin menghapus patch "${patchName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
      return
    }

    try {
      const response = await fetch(this.baseUrl, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=delete&id=${id}&${this.csrfToken}=${this.csrfHash}`,
      })

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }

      const result = await response.json()

      if (result.success) {
        this.showNotification("Patch berhasil dihapus", "success")

        // Remove the table row with animation
        btn.closest("tr").style.transition = "opacity 0.3s"
        btn.closest("tr").style.opacity = "0"
        setTimeout(() => btn.closest("tr").remove(), 300)

        // Update count
        setTimeout(() => this.updateResultsCount(), 350)
      } else {
        throw new Error(result.error || "Gagal menghapus patch")
      }
    } catch (error) {
      console.error("Delete error:", error)
      this.showNotification(error.message, "error")
    }
  }

  /**
   * Handle download button click
   */
  async handleDownload(e) {
    const btn = e.target.closest("button")
    const id = btn.dataset.id

    if (!id) {
      this.showNotification("ID patch tidak valid", "error")
      return
    }

    // Show loading state
    const originalText = btn.innerHTML
    btn.disabled = true
    btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Memproses...'

    try {
      const response = await fetch(this.baseUrl, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=download&id=${id}&${this.csrfToken}=${this.csrfHash}`,
      })

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }

      const result = await response.json()

      if (result.success) {
        if (result.data && result.data.download_url) {
          this.triggerDownload(result.data.download_url, result.data.filename)

          // Update download count in UI
          if (result.data.new_count) {
            const countCell = btn.closest("tr").querySelector("td:nth-child(4) span")
            countCell.textContent = this.formatNumber(result.data.new_count)
          }
        }
        this.showNotification("Download dimulai", "success")
      } else {
        throw new Error(result.error || "Gagal memulai download")
      }
    } catch (error) {
      console.error("Download error:", error)
      this.showNotification(error.message, "error")
    } finally {
      // Restore button state
      btn.disabled = false
      btn.innerHTML = originalText
    }
  }

  /**
   * Populate edit form with patch data
   */
  populateEditForm(data) {
    document.getElementById("edit_id").value = data.id
    document.getElementById("edit_nama_paket").value = data.nama_paket
    document.getElementById("edit_versi").value = data.versi
    document.getElementById("edit_prioritas").value = data.prioritas
    document.getElementById("edit_tanggal_rilis").value = data.tanggal_rilis
    document.getElementById("edit_ukuran").value = data.ukuran
    document.getElementById("edit_deskripsi").value = data.deskripsi
  }

  /**
   * Trigger file download
   */
  triggerDownload(url, filename = "patch.zip") {
    const a = document.createElement("a")
    a.href = url
    a.download = filename
    a.style.display = "none"
    document.body.appendChild(a)
    a.click()
    document.body.removeChild(a)
  }

  /**
   * Set button loading state
   */
  setButtonLoading(button, isLoading, originalText = "") {
    if (isLoading) {
      button.disabled = true
      button.classList.add("loading")
      if (!originalText) {
        originalText = button.innerHTML
      }
      button.setAttribute("data-original-text", originalText)
    } else {
      button.disabled = false
      button.classList.remove("loading")
      const storedText = button.getAttribute("data-original-text")
      button.innerHTML = storedText || originalText
      button.removeAttribute("data-original-text")
    }
  }

  /**
   * Reset form to initial state
   */
  resetForm(selector) {
    const form = document.querySelector(selector)
    if (form) {
      form.reset()

      // Remove validation classes
      const fields = form.querySelectorAll(".is-invalid, .is-valid")
      fields.forEach((field) => field.classList.remove("is-invalid", "is-valid"))
      const feedbacks = form.querySelectorAll(".invalid-feedback")
      feedbacks.forEach((feedback) => feedback.remove())

      // Reset date to today for add form
      if (selector === "#addPatchForm") {
        this.setDefaultDate()
      }
    }
  }

  /**
   * Validate individual form field
   */
  validateField(field) {
    const value = field.value.trim()
    let isValid = true
    let errorMessage = ""

    // Remove existing validation classes
    field.classList.remove("is-invalid", "is-valid")
    const feedback = field.nextElementSibling
    if (feedback && feedback.classList.contains("invalid-feedback")) {
      feedback.remove()
    }

    // Required field validation
    if (field.required && !value) {
      isValid = false
      errorMessage = "Field ini wajib diisi"
    }

    // Specific field validations
    switch (field.name) {
      case "nama_paket":
        if (value && value.length < 3) {
          isValid = false
          errorMessage = "Nama paket minimal 3 karakter"
        }
        break

      case "versi":
        if (value && !/^[0-9]+(\.[0-9]+)*$/.test(value)) {
          isValid = false
          errorMessage = "Format versi tidak valid (contoh: 1.0.0)"
        }
        break

      case "deskripsi":
        if (value && value.length < 10) {
          isValid = false
          errorMessage = "Deskripsi minimal 10 karakter"
        }
        break
    }

    // Apply validation classes
    if (value) {
      // Only validate if field has value
      if (isValid) {
        field.classList.add("is-valid")
      } else {
        field.classList.add("is-invalid")
        const newFeedback = document.createElement("div")
        newFeedback.className = "invalid-feedback"
        newFeedback.textContent = errorMessage
        field.parentNode.insertBefore(newFeedback, field.nextSibling)
      }
    }

    return isValid
  }

  /**
   * Validate entire form
   */
  validateForm(form) {
    let isValid = true

    const requiredFields = form.querySelectorAll("input[required], select[required], textarea[required]")
    requiredFields.forEach((field) => {
      if (!this.validateField(field)) {
        isValid = false
      }
    })

    return isValid
  }

  /**
   * Show notification message
   */
  showNotification(message, type) {
    const alertClass = type === "success" ? "alert-success" : "alert-danger"
    const iconClass = type === "success" ? "bi-check-circle" : "bi-exclamation-triangle"

    const html = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="bi ${iconClass} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `

    // Remove existing alerts
    const alerts = document.querySelectorAll(".container-fluid .alert")
    alerts.forEach((alert) => alert.remove())

    // Add new alert
    const container = document.querySelector(".container-fluid")
    container.insertAdjacentHTML("afterbegin", html)

    // Scroll to top
    document.documentElement.scrollTop = 0

    // Auto dismiss after 5 seconds
    setTimeout(() => {
      const alerts = document.querySelectorAll(".alert")
      alerts.forEach((alert) => alert.classList.add("fade", "show"))
      setTimeout(() => {
        alerts.forEach((alert) => alert.remove())
      }, 300)
    }, 5000)
  }

  /**
   * Format number with thousand separators
   */
  formatNumber(num) {
    return new Intl.NumberFormat("id-ID").format(num)
  }

  /**
   * Debounce function to limit function calls
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
  // Check if required config exists
  if (typeof window.patchConfig === "undefined") {
    console.error("Patch configuration not found")
    return
  }

  // Initialize patch manager
  new PatchManager()

  // Add some additional UI enhancements
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((tooltip) => new window.bootstrap.Tooltip(tooltip))

  // Auto-hide alerts after page load
  setTimeout(() => {
    document.querySelectorAll(".alert").forEach((alert) => {
      if (!alert.classList.contains("alert-warning")) {
        alert.classList.add("fade", "show")
        setTimeout(() => alert.remove(), 300)
      }
    })
  }, 3000)
})

// Export for potential external use
window.PatchManager = PatchManager
