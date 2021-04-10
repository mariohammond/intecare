<div class="container pdf-training">
    <h1>Part Three: Identify What Activity Codes to Use</h1>
    <h2>Quiz (Answer All Answers Correctly To Continue)</h2>
    <ol>
        <li>Billable Activities Fall Under Multiple Codes</li>
        <input id="q1False" type="radio" name="q1" value="incorrect" onclick="showResponse1()"/> True<br>
        <input id="q1True" type="radio" name="q1" value="correct" onclick="showResponse1()"> False<br>
        <p class="radio-response q1 incorrect red">Incorrect – Anytime you are billing, code the time to code A.</p>
        <p class="radio-response q1 correct green">Correct – Anytime you are billing, code the time to code A.</p>
        
        <li>All Paperwork Falls under Code N: General Administration</li>
        <input id="q2True" type="radio" name="q2" value="incorrect" onclick="showResponse2()"> True<br>
        <input id="q2False" type="radio" name="q2" value="correct" onclick="showResponse2()"> False<br>
        <p class="radio-response q2 incorrect red">Incorrect – Paperwork that is a direct result or in direct support of an activity you performed is coded the same code as the activity. For example, if you provided counseling services to a client and are writing the notes from that session with the client, you would code the time writing the notes to code A, the same code as the activity of providing the counseling to the client. If you find you are using mostly code N, please call us at 1-888-591-6128. The activities you are performing may fall under another code.</p>
        <p class="radio-response q2 correct green">Correct - Paperwork that is a direct result or in direct support of an activity you performed is coded the same code as the activity. For example, if you provided counseling services to a client and are writing the notes from that session with the client, you would code the time writing the notes to code A, the same code as the activity of providing the counseling to the client. If you find you are using mostly code N, please call us at 1-888-591-6128. The activities you are performing may fall under another code.</p>

        <li>Any time spent driving during your work day falls under the same code as the activity you are on your way to perform.</li>
        <input id="q3True" type="radio" name="q3" value="correct" onclick="showResponse3()"> True<br>
        <input id="q3False" type="radio" name="q3" value="incorrect" onclick="showResponse3()"> False<br>
        <p class="radio-response q3 incorrect red">Incorrect - Time spent driving during the work day is always coded the same code as the activity you are on your way to perform.</p>
        <p class="radio-response q3 correct green">Correct – Time spent driving during the work day is always coded the same code as the activity you are on your way to perform.</p>

        <li>Time spent completing the time study falls under code N: General Administration</li>
        <input id="q4True" type="radio" name="q4" value="correct" onclick="showResponse4()"> True<br>
        <input id="q4False" type="radio" name="q4" value="incorrect" onclick="showResponse4()"> False<br>
        <p class="radio-response q4 correct green">Correct – When completing the time study paperwork code the time to code N.</p>
        <p class="radio-response q4 incorrect red">Incorrect – When completing the time study paperwork code the time to code N.</p>

        <li>For paid time off you should code 12 hours as code N: General Administration</li>
        <input id="q5True" type="radio" name="q5" value="incorrect" onclick="showResponse5()"> True<br>
        <input id="q5False" type="radio" name="q5" value="correct" onclick="showResponse5()"> False<br>
        <p class="radio-response q5 incorrect red">Incorrect – Do not fill in code N for the entire day of the time study (which represents 12 hours) unless you are paid for 12 hours.  You should only use code N for the number of hours you are paid for. For example, if you have a paid day off where you are paid for 8 hours, you would code N for hours 1 through 8 the 45 minute increment on the time study. Hours 9 through 12 would be coded as &quot;not scheduled to work&quot; using code O.</p>
        <p class="radio-response q5 correct green">Correct – You should only use code N for the number of hours you are paid for. For example, if you have a paid day off where you are paid for 8 hours, you would code N for hours 1 through 8 the 45 minute increment on the time study. Hours 9 through 12 would be coded as &quot;not scheduled to work&quot; using code O.</p>

        <li>Time spent being &quot;on call&quot; when you aren’t doing another work related activity is coded to code O.</li>
        <input id="q6True" type="radio" name="q6" value="correct" onclick="showResponse6()"> True<br>
        <input id="q6False" type="radio" name="q6" value="incorrect" onclick="showResponse6()"> False<br>
        <p class="radio-response q6 correct green">Correct - If you are on call, but not doing anything else work related, code that time to code O. When you do receive a call, you can code it according to the activity you perform responding to the call.</p>
        <p class="radio-response q6 incorrect red">Incorrect - If you are on call, but not doing anything else work related, code that time to code O. When you do receive a call, you can code it according to the activity you perform responding to the call.</p>

        <li>Time spent on the phone is coded to the code that represents the activity you are performing on the phone.</li>
        <input id="q7True" type="radio" name="q7" value="correct" onclick="showResponse7()"> True<br>
        <input id="q7False" type="radio" name="q7" value="incorrect" onclick="showResponse7()"> False<br>
        <p class="radio-response q7 correct green">Correct - There is not one code that covers any type of phone call. Instead, think of what you are doing on the call and code that activity.</p>
        <p class="radio-response q7 incorrect red">Incorrect - There is not one code that covers any type of phone call. Instead, think of what you are doing on the call and code that activity.</p>
    </ol>
</div>

<script>
    var response1, response2, response3, response4, response5, response6, response7;

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

    function showResponse6() {
        $(".radio-response.q6").hide();
        response6 = $("input[name='q6']:checked").val();
        if (response6 == "correct") {
            $(".radio-response.q6.correct").show();
        } else {
            $(".radio-response.q6.incorrect").show();
        }
        checkAllResponses();
    }

    function showResponse7() {
        $(".radio-response.q7").hide();
        response7 = $("input[name='q7']:checked").val();
        if (response7 == "correct") {
            $(".radio-response.q7.correct").show();
        } else {
            $(".radio-response.q7.incorrect").show();
        }
        checkAllResponses();
    }

    function checkAllResponses() {
        if (response1 == "correct" && response2 == "correct" && response3 == "correct" && response4 == "correct" && response5 == "correct" && response6 == "correct" && response7 == "correct") {
            $(".fa-chevron-right").show();
        } else {
            $(".fa-chevron-right").hide();
        }
    }
</script>

<?php require "footer.php"; ?>