// progress loader JS
function progressLoader(array) {
    if (array.length != 0) {
        let i = 0;

        function updateProgress() {
            document.getElementById("progress-text").innerHTML = array[i][0];
            i = (i + 1) % array.length; // Increment i and reset to 0 if it reaches array length
            setTimeout(updateProgress, array[i][1]);
        }

        updateProgress(); // Start the progress updates
    }
}