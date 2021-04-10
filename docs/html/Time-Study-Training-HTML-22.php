<div class="container pdf-training">
    <h1>Part One: Understanding The MHFRP</h1>
    <h2>Quiz</h2>
    <ol>
        <li>The MHFRP is a Federal Reimbursement Program that is a sizable source of funding for your agency.</li>
        <input id="q1True" type="radio" name="q1" value="correct" onclick="showResponse1()"/> True<br>
        <input id="q1False" type="radio" name="q1" value="incorrect" onclick="showResponse1()"> False<br>
        <p class="radio-response q1 correct green">Correct – The MHFRP is a very important source of funding for your agency.</p>
        <p class="radio-response q1 incorrect red">Incorrect - The MHFRP is a very important source of funding for your agency.</p>
        
        <li>The time study is a productivity tool.</li>
        <input id="q2True" type="radio" name="q2" value="incorrect" onclick="showResponse2()"> True<br>
        <input id="q2False" type="radio" name="q2" value="correct" onclick="showResponse2()"> False<br>
        <p class="radio-response q2 incorrect red">Incorrect - The time studies from all participating agencies are aggregated together to produce a statewide percentage of time spent on reimbursable Medicaid Administrative Activities.</p>
        <p class="radio-response q2 correct green">Correct – The time studies from all participating agencies are aggregated together to produce a statewide percentage of time spent on reimbursable Medicaid Administrative Activities.</p>

        <li>Your Participation is Key to the Success of This Program.</li>
        <input id="q3True" type="radio" name="q3" value="correct" onclick="showResponse3()"> True<br>
        <input id="q3False" type="radio" name="q3" value="incorrect" onclick="showResponse3()"> False<br>
        <p class="radio-response q3 correct green">Correct - Yes, without the completed time studies we could not file a claim on behalf of your agencies. Your participation is essential to the program!</p>
        <p class="radio-response q3 incorrect red">Incorrect - without the completed time studies we could not file a claim on behalf of your agencies. Your participation is essential to the program!</p>
    </ol>
</div>

<script>
    var response1, response2, response3;

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

    function checkAllResponses() {
        if (response1 == "correct" && response2 == "correct" && response3 == "correct") {
            $(".fa-chevron-right").show();
        }
    }
</script>

<?php require "footer.php"; ?>