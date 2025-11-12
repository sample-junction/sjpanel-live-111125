<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0SQ2T8ZR4E"></script>
<script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());
         gtag('config', 'G-0SQ2T8ZR4E');
</script>
<div class="container">
    <meta name="description" content="{{ $metaData['meta_description'] }}">
    <meta name="keywords" content="{{ $metaData['meta_keyword'] }}">
    <!-- Status Modal -->
    <div id="statusModal" class="status-modal" style="display: flex;">
        <div class="status-content">

            <!-- Status Image with Progress Bar -->
            <div id="statusImageContainer" class="status-image-container">
                <div id="progressBarContainer" class="progress-bar-container"></div>
                <img id="statusImage" src="" alt="Status Image">
                <div id="statusCaption" class="status-caption"></div>
                <div id="shareIconContainer" class="share-icon-container">
                    <button id="nextPageBtn" class="next-page-btn">Read More</button>
                </div>
            </div>
            <input type="hidden" id="statusesData" value="{{ json_encode($statuses) }}">
            <!-- Navigation Controls -->
            <div id="navControls" class="nav-controls">
                <button id="prevBtn" onclick="prevStatus()">❮</button>
                <button id="nextBtn" onclick="nextStatus()">❯</button>
            </div>
            <!-- Play/Pause Button -->
            <span id="pauseBtn" class="pause-play-btn" onclick="pauseStatus()" style="display: block;">⏸</span>
            <span id="playBtn" class="pause-play-btn" onclick="playStatus()" style="display: none;">▶</span>
        </div>
    </div>
</div>
<style>

    .pause-play-btn {
        position: absolute;
        top: 28px;
        right: 120px;
        font-size: 30px;
        color: #fff; /* Make the icon white */
        cursor: pointer;
        z-index: 3;
        background-color: rgba(0, 0, 0, 0.6); /* Slight dark background for contrast */
        padding: 3px;
        border-radius: 20%; /* Make the button round */
        box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.6); /* Adding shadow for better visibility */
    }

    .pause-play-btn:hover {
        background-color: rgba(0, 0, 0, 0.8); /* Darken on hover */
    }

    #pauseBtn {
        display: block;
    }

    #playBtn {
        display: none;
    }

    .status-caption {
        position: absolute;
        bottom: 15%;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        color: white;
        font-size: 18px;
        background: rgba(0, 0, 0, 0.5);
        padding: 10px;
        border-radius: 0px;
        z-index: 3;
        width: 80%;
        margin-bottom: 10px;
    }
    .status-title {
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        margin-bottom: 5px; /* Space between title and caption */
    }

    .next-page-btn {
        background-color: #007bff;
        color: white;
        font-size: 18px;
        margin: 20px auto; /* Centers the button horizontally */
        text-align: center; /* Centers text inside button */
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .next-page-btn:hover {
        background-color: #0056b3;
    }

    .share-icon-container {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
        width: 100%;
        z-index: 3;
    }

    .status-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(10px); /* Apply background blur */
        padding: 0;
    }

    .status-content {
        position: relative;
        width: 40%;
        height: 100%; /* Adjusted height to allow for top/bottom padding */
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        overflow: hidden;
        padding: 10px 0; /* Added padding on top and bottom */
        border-radius: 10px; /* Optional: rounded corners for the modal itself */
        text-align: center;
    }

    .status-image-container {
        position: relative;
        width: 70%;
        height: 100%;
        padding-bottom: 177.78%; 
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0; /* Reduced padding */
        margin: 0; /* Removed margin */

    }

    .status-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px; /* Minor rounding of image corners */
        margin-top: 0; /* Removed margin */
        margin-bottom: 0; /* Removed margin */
    }


    .progress-bar-container {
        position: absolute;
        top: 3px;
        left: 5px;
        width: 95%;
        height: 5px;
        display: flex;
        gap: 5px; 
        z-index: 2;
        background: rgba(255, 255, 255, 0.3);
        padding: 2px;
        border-radius: 5px;
    }

    /* Progress bar styling */
    .progress-bar {
        height: 100%;
        background-color: rgba(255, 255, 255, 0.5);
        flex-grow: 1;
        position: relative;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.4); /* Shadow for visibility */
    }

    .progress-bar.completed {
        background-color: green; /* Green when complete */
    }

    /* Keyframe for animation */
    @keyframes progressSlide {
        from {
            width: 0%;
        }
        to {
            width: 100%;
        }
    }

    .nav-controls {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        z-index: 2;
    }

    #prevBtn {
        background-color: #007bff;
        color: white;
        font-size: 20px; /* Adjust font size if needed */
        border: none;
        width: 50px; /* Set explicit width */
        height: 50px; /* Set equal height */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0; /* Remove padding */
        cursor: pointer;
        z-index: 2;
        position: absolute;
        left: -30px;
        border-radius: 50%; /* Ensure perfect circle */
        box-shadow: 0px 4px 8px rgba(255, 255, 255, 0.8);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    #nextBtn {
        background-color: #007bff;
        color: white;
        font-size: 20px;
        width: 50px; /* Fixed width */
        height: 50px; /* Fixed height */
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        padding: 0; /* Remove padding */
        cursor: pointer;
        z-index: 2;
        position: absolute;
        top: 5px;
        right: -30px; /* Adjusted for better alignment */
        border-radius: 50%; /* Perfect circle */
        box-shadow: 0px 4px 8px rgba(255, 255, 255, 0.8);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    #prevBtn {
        left: 10px; /* Position to the left */
    }

    #nextBtn {
        right: 10px; /* Position to the right */
    }

    #prevBtn.hidden,
    #nextBtn.hidden {
        display: none !important;
    }
    @media (min-width: 768px) and (max-width: 991px) {
        .container, .status-modal{
            height:100%;
        }
        .status-content{
            width: 90%;
        }
        .status-image-container{
            width: 100%;
        }
        .progress-bar-container {
            position: absolute;
            top: 23px;
            left: 15px;
            width: 95%;
            height: 5px;
            display: flex;
            gap: 5px;
            z-index: 2;
            background: rgba(255, 255, 255, 0.3);
            padding: 2px;
            border-radius: 5px;
        }
        .pause-play-btn {
            position: absolute;
            top: 60px;
            right: 55px;
            font-size: 30px;
            color: #fff;
            cursor: pointer;
            z-index: 3;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 3px;
            border-radius: 20%;
            box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.6);
        }

        #prevBtn {
            background-color: #007bff;
            color: white;
            font-size: 30px; /* Adjust font size if needed */
            border: none;
            width: 100px; /* Set explicit width */
            height: 100px; /* Set equal height */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0; /* Remove padding */
            cursor: pointer;
            z-index: 2;
            position: absolute;
            left: -30px;
            border-radius: 50%; /* Ensure perfect circle */
            box-shadow: 0px 6px 12px rgba(255, 255, 255, 0.8);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        #nextBtn {
            background-color: #007bff;
            color: white;
            font-size: 30px;
            width: 100px; /* Fixed width */
            height: 100px; /* Fixed height */
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            padding: 0; /* Remove padding */
            cursor: pointer;
            z-index: 2;
            position: absolute;
            top: 5px;
            right: -30px; /* Adjusted for better alignment */
            border-radius: 50%; /* Perfect circle */
            box-shadow: 0px 6px 12px rgba(255, 255, 255, 0.8);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        #prevBtn {
            left: 10px; /* Position to the left */
        }

        #nextBtn {
            right: 10px; /* Position to the right */
        }

        #prevBtn.hidden,
        #nextBtn.hidden {
            display: none !important;
        }
    }
    @media  (max-width: 768px) {
        .container, .status-modal, .status-image-container{
            height:100%;
        }
        .status-content{
            width: 90%;
        }
        .status-image-container{
            width: 100%;
        }
        .progress-bar-container {
            position: absolute;
            top: 23px;
            left: 15px;
            width: 95%;
            height: 5px;
            display: flex;
            gap: 5px;
            z-index: 2;
            background: rgba(255, 255, 255, 0.3);
            padding: 2px;
            border-radius: 5px;
        }
        .pause-play-btn {
            position: absolute;
            top: 60px;
            right: 55px;
            font-size: 30px;
            color: #fff;
            cursor: pointer;
            z-index: 3;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 3px;
            border-radius: 20%;
            box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.6);
        }

        #prevBtn {
            background-color: #007bff;
            color: white;
            font-size: 30px; /* Adjust font size if needed */
            border: none;
            width: 100px; /* Set explicit width */
            height: 100px; /* Set equal height */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0; /* Remove padding */
            cursor: pointer;
            z-index: 2;
            position: absolute;
            left: -30px;
            border-radius: 50%; /* Ensure perfect circle */
            box-shadow: 0px 6px 12px rgba(255, 255, 255, 0.8);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        #nextBtn {
            background-color: #007bff;
            color: white;
            font-size: 30px;
            width: 100px; /* Fixed width */
            height: 100px; /* Fixed height */
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            padding: 0; /* Remove padding */
            cursor: pointer;
            z-index: 2;
            position: absolute;
            top: 5px;
            right: -30px; /* Adjusted for better alignment */
            border-radius: 50%; /* Perfect circle */
            box-shadow: 0px 6px 12px rgba(255, 255, 255, 0.8);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        #prevBtn {
            left: 10px; /* Position to the left */
        }

        #nextBtn {
            right: 10px; /* Position to the right */
        }

        #prevBtn.hidden,
        #nextBtn.hidden {
            display: none !important;
        }
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const statusImg = document.getElementById("statusImage");
        const statusModal = document.getElementById("statusModal");
        const style = document.createElement('style');
        style.innerHTML = `
            .progress-bar {
                height: 100%;
                background: linear-gradient(to right, green var(--progress-width, 0%), rgba(255,255,255,0.3) var(--progress-width, 0%));
                border-radius: 5px;
                width: 100%; /* Full width, only green fill moves */
            }
        `;
        document.head.appendChild(style);
        // Initialize Color Thief
        const colorThief = new ColorThief();

        function setBackgroundBlurColor(imageElement) {
            if (imageElement.complete) {
                try {
                    const dominantColor = colorThief.getColor(imageElement);

                    const rgbaColor = `rgba(${dominantColor[0]}, ${dominantColor[1]}, ${dominantColor[2]}, 0.6)`;

                    statusModal.style.background = rgbaColor;
                    statusModal.style.backdropFilter = 'blur(10px)';
                } catch (error) {
                    console.error("Color Thief Error: ", error);
                }
            } else {
                imageElement.addEventListener('load', function () {
                    setBackgroundBlurColor(imageElement);
                });
            }
        }

        // Update background blur when a new image is loaded
        statusImg.onload = function() {
            setBackgroundBlurColor(statusImg);
        };

        // Ensure background color is set when image loads initially
        if (statusImg.complete) {
            setBackgroundBlurColor(statusImg);
        }
    });

    let modal = document.getElementById("statusModal");
    let statusImg = document.getElementById("statusImage");
    let progressBarContainer = document.getElementById("progressBarContainer");
    let storyStatus = [];
    let currentStatusIndex = 0;
    let isPaused = false;
    let progressStartTime = 0;
    let elapsedProgressTime = 0;
    let progressDuration = 3000; // 3 seconds per status
    let progressAnimationFrame;
    let lastProgress = 0;

    function pauseStatus() {
        if (isPaused) return; // Already paused

        isPaused = true;
        elapsedProgressTime = performance.now() - progressStartTime; // Store exact elapsed time
        lastProgress = (elapsedProgressTime / progressDuration) * 100;

        document.getElementById("pauseBtn").style.display = "none";
        document.getElementById("playBtn").style.display = "block";

        if (progressAnimationFrame) {
            cancelAnimationFrame(progressAnimationFrame); // Stop animation immediately
            progressAnimationFrame = null; // Ensure it's fully stopped
        }

        // Immediately update progress bar to reflect paused state
        const progressBar = document.querySelectorAll('.progress-bar')[currentStatusIndex];
        if (progressBar) {
            progressBar.style.setProperty('--progress-width', `${lastProgress}%`);
        }
    }

    function playStatus() {
        if (!isPaused) return;

        isPaused = false;
        document.getElementById("playBtn").style.display = "none";
        document.getElementById("pauseBtn").style.display = "block";

        // Resume from the exact paused position
        progressStartTime = performance.now() - elapsedProgressTime;
        animateProgress(currentStatusIndex, elapsedProgressTime);
    }

    function animateProgress(index, startOffset) {
        const progressBar = document.querySelectorAll('.progress-bar')[index];
        if (!progressBar) return;

        function step(timestamp) {
            if (isPaused) {
                return; // If paused, stop the animation
            }

            let elapsed = timestamp - progressStartTime;
            let progress = Math.min(elapsed / progressDuration, 1) * 100;
            progressBar.style.setProperty('--progress-width', `${progress}%`);

            if (progress < 100) {
                progressAnimationFrame = requestAnimationFrame(step);
            } else if (!isPaused) {
                nextStatus();
            }
        }

        progressAnimationFrame = requestAnimationFrame(step);
    }
    function renderProgressBars() {
        progressBarContainer.innerHTML = ''; // Clear existing progress bars
        storyStatus.forEach((_, i) => {
            const progressBar = document.createElement('div');
            progressBar.className = 'progress-bar' + (i === currentStatusIndex ? ' active' : '');
            progressBarContainer.appendChild(progressBar);
        });

        // Reset the progress bar for the current status
        const progressBar = document.querySelectorAll('.progress-bar')[currentStatusIndex];
        if (progressBar) {
            progressBar.style.setProperty('--progress-width', '0%'); // Reset progress to 0%
        }
    }

    function overwriteBaseUrl(url) {
        const urlObj = new URL(url); // Create a URL object
        const path = urlObj.pathname;
        
        // Prepend the new base URL
        return 'https://www.samplejunction.com' + path;
    }
    
    function loadStatus(index) {
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const nextPageBtn = document.getElementById("nextPageBtn");
        const shareIconContainer = document.getElementById("shareIconContainer");
        const statusCaption = document.getElementById("statusCaption");

        prevBtn.classList.toggle('hidden', index === 0);
        nextBtn.classList.toggle('hidden', index === storyStatus.length - 1);

        const currentStatus = storyStatus[index];

        statusImg.src = overwriteBaseUrl(currentStatus.url);

        // Check if either title or caption exists
        let titleHTML = currentStatus.image_title ? `<div class="status-title">${currentStatus.image_title}</div>` : '';
        let captionHTML = currentStatus.caption ? `<div>${currentStatus.caption}</div>` : '';

        // If at least one exists, show them; otherwise, clear statusCaption
        if (titleHTML || captionHTML) {
            statusCaption.innerHTML = titleHTML + captionHTML;
            statusCaption.style.display = "block";  // Ensure it's visible
        } else {
            statusCaption.innerHTML = "";  // Remove any existing content
            statusCaption.style.display = "none";  // Hide completely
        }

        // Always show Read More button on the last image
        if (index === storyStatus.length - 1) {
            shareIconContainer.style.display = "block";
            nextPageBtn.style.display = "block";

            nextPageBtn.onclick = function () {
                let url = currentStatus.redirect_link;

                // Ensure URL starts with http:// or https://
                if (!url.startsWith("http://") && !url.startsWith("https://")) {
                    url = "https://" + url;  // Default to HTTPS
                }

                window.open(url, '_blank');
            };
        } else {
            shareIconContainer.style.display = "none";
            nextPageBtn.style.display = "none";
        }

        // Render progress bars and start progress animation
        renderProgressBars();
        // Wait for the image to load before starting the progress bar
        statusImg.onload = function() {
            startProgress(index);
        };
    }

    function startProgress(index) {
        if (progressAnimationFrame) {
            cancelAnimationFrame(progressAnimationFrame); // Cancel any existing animation
        }
        elapsedProgressTime = 0; // Reset when new status loads
        progressStartTime = performance.now();

        animateProgress(index, 0);
    }

    function nextStatus() {
        if (currentStatusIndex < storyStatus.length - 1) {
            currentStatusIndex++;
            loadStatus(currentStatusIndex);
        }
    }

    function prevStatus() {
        if (currentStatusIndex > 0) {
            currentStatusIndex--;
            loadStatus(currentStatusIndex);
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Get the statuses data from the hidden input field
        const statusesData = document.getElementById('statusesData').value;

        if (statusesData) {
            // Parse the JSON data
            storyStatus = JSON.parse(statusesData);

            let currentStatusIndex = 0;
            loadStatus(currentStatusIndex);

        }
    });
</script>
