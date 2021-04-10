<div class="container pdf-training">
    <h1>Part Two: Learn How To Complete The Time Study</h1>
    <h2>Quiz (Answer All Answers Correctly To Continue)</h2>
    <ol>
        <li>Complete both the notes and activity code columns and submit after the time study week.</li>
        <input id="q1True" type="radio" name="q1" value="correct" onclick="showResponse1()"/> True<br>
        <input id="q1False" type="radio" name="q1" value="incorrect" onclick="showResponse1()"> False<br>
        <p class="radio-response q1 correct green">Correct – Complete both the notes and activity code columns and press submit once you sign the signature page.</p>
        <p class="radio-response q1 incorrect red">Incorrect - Complete both the notes and activity code columns and press submit once you sign the signature page.</p>
        
        <li>Anyone can use codes G2 and J2 when coding their activities.</li>
        <input id="q2True" type="radio" name="q2" value="incorrect" onclick="showResponse2()"> True<br>
        <input id="q2False" type="radio" name="q2" value="correct" onclick="showResponse2()"> False<br>
        <p class="radio-response q2 incorrect red">Incorrect - You must be in a SPMP category to use codes G2 and J2 when you are coding your time.</p>
        <p class="radio-response q2 correct green">Correct – You must be in a SPMP category to use codes G2 and J2 when you are coding your time.</p>

        <li>Only code the hours you want to.</li>
        <input id="q3True" type="radio" name="q3" value="incorrect" onclick="showResponse3()"> True<br>
        <input id="q3False" type="radio" name="q3" value="correct" onclick="showResponse3()"> False<br>
        <p class="radio-response q3 incorrect red">Incorrect – All hours of coding must be completed each of the seven days of the time study week. If you are not scheduled to work and the time is NOT paid, use code O.  If you are not working and you have paid time off, use code N for the hours you are paid.</p>
        <p class="radio-response q3 correct green">Correct – All of your work activities should be recorded up to the first 12 hours of each day of the time study week. If you are not working and you have paid time off, use code N for the hours you are paid.  If you are not working and the time is NOT paid, use code O.</p>

        <li>Leave the time study blank for the day if you do not work on a particular day of the time study week.</li>
        <input id="q4True" type="radio" name="q4" value="incorrect" onclick="showResponse4()"> True<br>
        <input id="q4False" type="radio" name="q4" value="correct" onclick="showResponse4()"> False<br>
        <p class="radio-response q4 incorrect red">Incorrect – All of your work activities should be recorded up to the first 12 hours of each day of the time study week. If you are not working and you have paid time off, use code N for the hours you are paid. If you are not working and the time is NOT paid, use code O.</p>
        <p class="radio-response q4 correct green">Correct - All of your work activities should be recorded up to the first 12 hours of each day of the time study week. If you are not working and you have paid time off, use code N for the hours you are paid. If you are not working and the time is NOT paid, use code O.</p>

        <li>Mark multiple codes if you performed several activities within a 15 minute increment.</li>
        <input id="q5True" type="radio" name="q5" value="incorrect" onclick="showResponse5()"> True<br>
        <input id="q5False" type="radio" name="q5" value="correct" onclick="showResponse5()"> False<br>
        <p class="radio-response q5 incorrect red">Incorrect – Only one code can be used for each 15 minute increment.  If you are doing multiple things in a given 15 minute period, use your best judgment to determine what activity took the majority of that 15 minutes and code it accordingly on your time study and record it on your PAL.</p>
        <p class="radio-response q5 correct green">Correct - Only one code can be used for each 15 minute increment.  If you are doing multiple things in a given 15 minute period, use your best judgment to determine what activity took the majority of that 15 minutes and code it accordingly on your time study and record it on your PAL.</p>
    </ol>
</div>

<script>
    var response1, response2, response3, response4, response5;

    function showResponse1() {
        $(".radio-response.q1").hide();
        response1 = $("input[name='q1']:checked").val();
        if (response1 == "correct") {
            $(".radio-response.q1.correct").show();
        } else {
            $(".radio-response.q1.incorrect").show();
        }
        checkAllResponses();
    }

    function showResponse2() {
        $(".radio-response.q2").hide();
        response2 = $("input[name='q2']:checked").val();
        if (response2 == "correct") {
            $(".radio-response.q2.correct").show();
        } else {
            $(".radio-response.q2.incorrect").show();
        }
        checkAllResponses();
    }

    function showResponse3() {
        $(".radio-response.q3").hide();
        response3 = $("input[name='q3']:checked").val();
        if (response3 == "correct") {
            $(".radio-response.q3.correct").show();
        } else {
            $(".radio-response.q3.incorrect").show();
        }
        checkAllResponses();
    }

    function showResponse4() {
        $(".radio-response.q4").hide();
        response4 = $("input[name='q4']:checked").val();
        if (response4 == "correct") {
            $(".radio-response.q4.correct").show();
        } else {
            $(".radio-response.q4.incorrect").show();
        }
        checkAllResponses();
    }

    function showResponse5() {
        $(".radio-response.q5").hide();
        response5 = $("input[name='q5']:checked").val();
        if (response5 == "correct") {
            $(".radio-response.q5.correct").show();
        } else {
            $(".radio-response.q5.incorrect").show();
        }
        checkAllResponses();
    }

    function checkAllResponses() {
        if (response1 == "correct" && response2 == "correct" && response3 == "correct" && response4 == "correct" && response5 == "correct") {
            $(".fa-chevron-right").show();
        } else {
            $(".fa-chevron-right").hide();
        }
    }
</script>

<?php require "footer.php"; ?>