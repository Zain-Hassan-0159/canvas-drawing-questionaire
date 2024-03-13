
class CanvasInitializer {
    constructor(questions, id) {
        this.questions = questions;
        this.id = id;
        this.initializeCanvas();
    }

    initializeCanvas() {
        const element = document.getElementById(this.id);
        const canvas = element.querySelector('.draw-canvas');
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;

        function startDrawing(e) {
            isDrawing = true;
            [lastX, lastY] = [e.offsetX, e.offsetY];
        }

        function draw(e) {
            if (!isDrawing) return;
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.strokeStyle = 'black';
            ctx.lineWidth = 2;
            ctx.stroke();
            [lastX, lastY] = [e.offsetX, e.offsetY];
        }

        function stopDrawing() {
            isDrawing = false;
        }

        function startDrawingTouch(e) {
            e.preventDefault();
            isDrawing = true;
            const rect = canvas.getBoundingClientRect();
            const touch = e.touches[0];
            [lastX, lastY] = [touch.clientX - rect.left, touch.clientY - rect.top];
        }

        function drawTouch(e) {
            if (!isDrawing) return;
            const rect = canvas.getBoundingClientRect();
            const touch = e.touches[0];
            const x = touch.clientX - rect.left;
            const y = touch.clientY - rect.top;
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(x, y);
            ctx.strokeStyle = 'black';
            ctx.lineWidth = 1;
            ctx.stroke();
            lastX = x;
            lastY = y;
        }

        function resetCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);

        canvas.addEventListener('touchstart', startDrawingTouch);
        canvas.addEventListener('touchmove', drawTouch);
        canvas.addEventListener('touchend', stopDrawing);
        canvas.addEventListener('touchcancel', stopDrawing);

        const results = [];
        let indx = 0;
        let questions = this.questions;

        element.querySelector('.saveBtn').addEventListener('click', function() {
            const image = canvas.toDataURL();
            results.push(image);
            indx++;
            if (indx === questions.length) {
                const arrayAsString = JSON.stringify(results);
                localStorage.setItem('questions_sign', arrayAsString);
                window.location.href = "https://psychicgraphology.com/index.php/your-reading/";
            } else {
                element.querySelector(".cdq_container p").innerHTML = questions[indx];
                resetCanvas();
            }
        });

        element.querySelector('.reset').addEventListener('click', resetCanvas);

        element.querySelector('.tap_to_start').addEventListener('click', function() {
            element.querySelector('.overlay_canvas').style.display = 'none';
            element.querySelector('.canvas').classList.remove("op-0");
        });
    }
}


// Call each initialization function when the window loads
    window.initializationFunctions.forEach(func => {
        func()
    });
