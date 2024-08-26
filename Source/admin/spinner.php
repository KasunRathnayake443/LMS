<!-- spinner.php -->
<div id="loading-container" class="d-flex align-items-center justify-content-center vh-100">
    <div class="spinner-grow text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-secondary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-success" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-danger" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-warning" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-info" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<style>
    #loading-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: white;
        z-index: 1050; /* Ensure it's above everything else */
    }
</style>

<script>
    window.addEventListener('load', function() {
        // Hide the spinner
        document.getElementById('loading-container').style.display = 'none';
        // Show the main content
        var content = document.getElementById('content');
        if (content) {
            content.style.display = 'block';
        }
    });
</script>
