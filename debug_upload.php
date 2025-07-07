<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Profile Upload</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 20px; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        .alert-info { background: #d1ecf1; color: #0c5460; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 5px; overflow-x: auto; }
        .upload-area { border: 2px dashed #ccc; padding: 20px; text-align: center; margin: 10px 0; }
        .upload-area:hover { border-color: #007bff; }
    </style>
</head>
<body>
    <h1>Debug Profile Photo Upload</h1>
    
    <div class="section">
        <h3>System Information</h3>
        <div id="systemInfo">
            <p><strong>Current URL:</strong> <span id="currentUrl"></span></p>
            <p><strong>Upload URL:</strong> <span id="uploadUrl"></span></p>
            <p><strong>Browser:</strong> <span id="browserInfo"></span></p>
        </div>
    </div>
    
    <div class="section">
        <h3>Test Upload</h3>
        <div class="upload-area" onclick="document.getElementById('fileInput').click()">
            <p>Click here to select a photo</p>
            <p><small>Supported: JPG, PNG, GIF (max 2MB)</small></p>
        </div>
        <input type="file" id="fileInput" accept="image/*" style="display: none;">
        <button class="btn" id="uploadBtn" style="display: none;">Upload Photo</button>
        <button class="btn" id="testConnectionBtn">Test Connection</button>
    </div>
    
    <div class="section">
        <h3>Debug Output</h3>
        <div id="debugOutput"></div>
    </div>
    
    <script>
        let selectedFile = null;
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('currentUrl').textContent = window.location.href;
            document.getElementById('uploadUrl').textContent = window.location.origin + '/test-upload-photo';
            document.getElementById('browserInfo').textContent = navigator.userAgent;
        });
        
        // File selection
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                selectedFile = file;
                document.getElementById('uploadBtn').style.display = 'inline-block';
                addDebugMessage('File selected: ' + file.name + ' (' + file.size + ' bytes)', 'info');
            }
        });
        
        // Test connection
        document.getElementById('testConnectionBtn').addEventListener('click', function() {
            testConnection();
        });
        
        // Upload button
        document.getElementById('uploadBtn').addEventListener('click', function() {
            if (selectedFile) {
                uploadFile(selectedFile);
            }
        });
        
        function testConnection() {
            addDebugMessage('Testing connection to upload endpoint...', 'info');
            
            fetch('/test-upload-photo', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                addDebugMessage('Connection test response: ' + response.status + ' ' + response.statusText, 
                    response.ok ? 'success' : 'danger');
                return response.text();
            })
            .then(text => {
                addDebugMessage('Response body: ' + text.substring(0, 200) + (text.length > 200 ? '...' : ''), 'info');
            })
            .catch(error => {
                addDebugMessage('Connection test failed: ' + error.message, 'danger');
            });
        }
        
        function uploadFile(file) {
            addDebugMessage('Starting upload for: ' + file.name, 'info');
            
            // Validate file
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                addDebugMessage('Invalid file type: ' + file.type, 'danger');
                return;
            }
            
            if (file.size > 2 * 1024 * 1024) {
                addDebugMessage('File too large: ' + file.size + ' bytes', 'danger');
                return;
            }
            
            // Create form data
            const formData = new FormData();
            formData.append('profile_photo', file);
            
            addDebugMessage('Sending upload request...', 'info');
            
            // Upload
            fetch('/test-upload-photo', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                addDebugMessage('Upload response: ' + response.status + ' ' + response.statusText, 
                    response.ok ? 'success' : 'danger');
                
                const contentType = response.headers.get('content-type');
                addDebugMessage('Response content-type: ' + contentType, 'info');
                
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    return response.text().then(text => {
                        addDebugMessage('Non-JSON response: ' + text.substring(0, 500), 'danger');
                        throw new Error('Expected JSON response but got: ' + contentType);
                    });
                }
            })
            .then(data => {
                addDebugMessage('Upload response data: ' + JSON.stringify(data, null, 2), 
                    data.success ? 'success' : 'danger');
                
                if (data.success) {
                    addDebugMessage('Upload successful! Photo URL: ' + data.photo_url, 'success');
                } else {
                    addDebugMessage('Upload failed: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                addDebugMessage('Upload error: ' + error.message, 'danger');
                console.error('Full error:', error);
            });
        }
        
        function addDebugMessage(message, type) {
            const debugOutput = document.getElementById('debugOutput');
            const timestamp = new Date().toLocaleTimeString();
            
            const messageDiv = document.createElement('div');
            messageDiv.className = 'alert alert-' + type;
            messageDiv.innerHTML = '<strong>[' + timestamp + ']</strong> ' + message;
            
            debugOutput.appendChild(messageDiv);
            debugOutput.scrollTop = debugOutput.scrollHeight;
        }
    </script>
</body>
</html>