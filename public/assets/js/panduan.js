// JavaScript for Panduan Page

document.addEventListener("DOMContentLoaded", () => {
  // Initialize page functionality
  initSearchFunctionality()
  initDocumentActions()

  console.log("Panduan Page loaded successfully")
})

// Search functionality
function initSearchFunctionality() {
  const searchInput = document.getElementById("searchInput")

  if (searchInput) {
    searchInput.addEventListener("input", (e) => {
      const searchTerm = e.target.value.toLowerCase()
      filterDocuments(searchTerm)
    })
  }
}

// Filter documents based on search term
function filterDocuments(searchTerm) {
  const documentItems = document.querySelectorAll(".document-item")

  documentItems.forEach((item) => {
    const title = item.querySelector("h5").textContent.toLowerCase()
    const description = item.querySelector("p").textContent.toLowerCase()

    if (title.includes(searchTerm) || description.includes(searchTerm)) {
      item.style.display = "block"
    } else {
      item.style.display = "none"
    }
  })

  // Update document count
  const visibleItems = document.querySelectorAll(
    '.document-item[style="display: block"], .document-item:not([style*="display: none"])',
  )
  const countElement = document.querySelector("h3.fw-bold span")
  if (countElement) {
    countElement.textContent = `(${visibleItems.length})`
  }
}

// Initialize document actions
function initDocumentActions() {
  // Add event listeners for document actions
  console.log("Document actions initialized")
}

// Download document function
function downloadDocument(documentId) {
  // Show loading state
  showNotification("Memulai unduhan...", "info")

  // Simulate download process
  setTimeout(() => {
    showNotification(`Dokumen ${documentId} berhasil diunduh!`, "success")
  }, 1000)

  console.log(`Downloading document ${documentId}`)
}

// Edit document function
function editDocument(documentId) {
  // Get document data (in real app, this would come from server)
  const documentItem = document.querySelector(`[data-document-id="${documentId}"]`)
  const title = documentItem.querySelector("h5").textContent
  const description = documentItem.querySelector("p").textContent

  // Populate edit form
  document.getElementById("documentTitle").value = title
  document.getElementById("documentDescription").value = description

  // Show modal
  const modal = window.bootstrap.Modal(document.getElementById("addDocumentModal"))
  modal.show()

  // Update modal title
  document.getElementById("addDocumentModalLabel").textContent = "Edit Dokumen"

  console.log(`Editing document ${documentId}`)
}

// Delete document function
function deleteDocument(documentId) {
  if (confirm("Apakah Anda yakin ingin menghapus dokumen ini?")) {
    const documentItem = document.querySelector(`[data-document-id="${documentId}"]`)

    // Add fade out animation
    documentItem.style.transition = "opacity 0.3s ease"
    documentItem.style.opacity = "0"

    setTimeout(() => {
      documentItem.remove()
      showNotification("Dokumen berhasil dihapus!", "success")

      // Update document count
      const remainingItems = document.querySelectorAll(".document-item")
      const countElement = document.querySelector("h3.fw-bold span")
      if (countElement) {
        countElement.textContent = `(${remainingItems.length})`
      }
    }, 300)

    console.log(`Deleting document ${documentId}`)
  }
}

// Save document function
function saveDocument() {
  const form = document.getElementById("addDocumentForm")
  const formData = new FormData(form)

  // Validate form
  if (!form.checkValidity()) {
    form.reportValidity()
    return
  }

  // Get form values
  const title = document.getElementById("documentTitle").value
  const description = document.getElementById("documentDescription").value
  const version = document.getElementById("documentVersion").value
  const type = document.getElementById("documentType").value
  const file = document.getElementById("documentFile").files[0]

  // Simulate file size calculation
  const fileSize = file ? (file.size / (1024 * 1024)).toFixed(1) + " MB" : "0 MB"

  // Create new document item
  const documentList = document.getElementById("documentList")
  const documentCount = documentList.children.length + 1

  const newDocumentHTML = `
    <div class="document-item border-bottom py-3" data-document-id="${documentCount}">
      <div class="row align-items-center">
        <div class="col-md-1">
          <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <span class="fw-bold">${documentCount}</span>
          </div>
        </div>
        <div class="col-md-7">
          <h5 class="fw-bold mb-1">${title}</h5>
          <p class="text-muted mb-2 small">${description}</p>
          <div class="d-flex align-items-center">
            <span class="badge bg-success me-2">${type}</span>
            <small class="text-muted me-3">${fileSize}</small>
            <small class="text-muted">${version}</small>
          </div>
        </div>
        <div class="col-md-4 text-end">
          <button class="btn btn-outline-secondary btn-sm me-2" onclick="downloadDocument(${documentCount})">
            <i class="fa-solid fa-download me-1"></i>Unduh
          </button>
          <button class="btn btn-outline-primary btn-sm me-2" onclick="editDocument(${documentCount})">
            <i class="fa-solid fa-edit me-1"></i>
          </button>
          <button class="btn btn-outline-danger btn-sm" onclick="deleteDocument(${documentCount})">
            <i class="fa-solid fa-trash me-1"></i>
          </button>
        </div>
      </div>
    </div>
  `

  // Add new document to list
  documentList.insertAdjacentHTML("beforeend", newDocumentHTML)

  // Update document count
  const countElement = document.querySelector("h3.fw-bold span")
  if (countElement) {
    countElement.textContent = `(${documentCount})`
  }

  // Close modal and reset form
  const modal = window.bootstrap.Modal.getInstance(document.getElementById("addDocumentModal"))
  modal.hide()
  form.reset()

  // Reset modal title
  document.getElementById("addDocumentModalLabel").textContent = "Tambah Dokumen Baru"

  showNotification("Dokumen berhasil ditambahkan!", "success")
}

// Show notification function
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

// Print page function
function printPage() {
  window.print()
}

// Export functions for global access
window.downloadDocument = downloadDocument
window.editDocument = editDocument
window.deleteDocument = deleteDocument
window.saveDocument = saveDocument
window.printPage = printPage

// Declare bootstrap variable
window.bootstrap = window.bootstrap || {}