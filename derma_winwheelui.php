<!DOCTYPE html>
<html>
<head>
    <title>Dermaskinshop Lucky Draw Wheel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="Winwheel.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="static/css/derma_winwheel.css">
</head>

    <body>
            <div class="border">
                <div class="box-sample">
                     <img src="static/assets/dermaskinshop-Logo-Color.png" alt="" class="derma-logo">
                </div>
            </div>
        <div id="wheelContainer">
            <canvas id='myCanvas' width='1024' height='768'>
                Canvas not supported, use another browser.
            </canvas>
            <img src="static/assets/derma_winpointer.png" id="winPointer" />
            <button onClick="changeColours();">Change Colours</button>
            <button id="spin_button" type="submit" onClick="startSpin();">Spin the Wheel</button>
            <button onClick="resetWheel();">Reset</button>
        </div>


        <script>
            let theWheel = new Winwheel({
                'canvasId'    : 'myCanvas',
                'numSegments' : 5,
                'outerRadius' : 200,
                'rotationAngle': -30,
                'segments'    :
                [
                    {'fillStyle' : '#eae56f', 'text' : 'Voucher\nRM50'},
                    {'fillStyle' : '#89f26e', 'text' : 'Voucher\nRM100','size':40},
                    {'fillStyle' : '#7de6ef', 'text' : 'Voucher\nDiscount 20%'},
                    {'fillStyle' : '#e7706f', 'text' : 'Voucher\nDiscount 40%', size:30},
                    {'fillStyle' : '#e7706f', 'text' : 'No Prize'}
                ],
                'animation': 
                {
                    'type': 'spinToStop',
                    'duration': 5,
                    'spins': 8,
                    'callbackFinished': 'alertPrize()'             
                },
                'lineWidth': 3
            });


            function changeColours()
            {
                // Change colours as desired by accessing the segment via the segments array
                // of the wheel object (note first array position is 1 not 0).
                let temp = theWheel.segments[1].fillStyle;
                theWheel.segments[1].fillStyle = theWheel.segments[2].fillStyle;
                theWheel.segments[2].fillStyle = theWheel.segments[3].fillStyle;
                theWheel.segments[3].fillStyle = theWheel.segments[4].fillStyle;
                theWheel.segments[4].fillStyle = theWheel.segments[5].fillStyle;
                theWheel.segments[5].fillStyle = temp;

                // The draw method of the wheel object must be called
                // in order for the changes to be rendered.
                theWheel.draw();
            }
            
            function startSpin(){
                document.getElementById("spin_button").disabled = true;
                theWheel.startAnimation();
                wheelSpinning = true;
            }

            function alertPrize(){
                // Call getIndicatedSegment() function to return pointer to the segment pointed to on wheel.
                let winningSegment = theWheel.getIndicatedSegment();
                
                // Basic alert of the segment text which is the prize name.
                alert("You have won " + winningSegment.text + "!");
            }

            function resetWheel()
            {
                theWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
                theWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
                theWheel.draw();                // Call draw to render changes to the wheel.
                document.getElementById("spin_button").disabled = false;
                wheelSpinning = false;          // Reset to false to power buttons and spin can be clicked again.
            }
        </script>
    </body>

</html>
