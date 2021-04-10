$(function() {
    var windowHeight = $(window).height();
    $('#page-fit.wrapper').css('height', windowHeight);

    $(window).resize(function() {
        var windowHeight = $(window).height();
        $('#page-fit.wrapper').css('height', windowHeight);
    });

    toggleEmployeePanel();
    filterEmployeeByPos();

    /*$(document).on('click', '.delete-btn', function() {
        var btnId = $(this).attr("id");
        var logCount = btnId.split("deleteBtn");
        $("#timelog-" + logCount[1]).remove();

        $('.delete-btn').hide();
        $('.delete-btn').last().show();

        $('#descAlert').hide();
        $('#codeAlert').hide();
    });*/

    $(".copy-btn").click(function(e) {
        // Get previous log
        var parentId = $(this).parents('.timelog').attr('id');
        var parentCount = parseInt(parentId.split("-")[1]);
        var prevParent = parentCount - 1;

        // Get values of previous log
        var prevCode = $('#codeInput' + prevParent).val();
        var prevDesc = $('#descriptionInput' + prevParent).val();

        // Add values to current log
        $('#codeInput' + parentCount).val(prevCode);
        $('#descriptionInput' + parentCount).val(prevDesc);
    });

    $(".save-btn").click(function(e) {
        var descValue, codeValue, matchingDesc, matchingCode;
        var descValid = true;
        var codeValid = true;

        $('#descAlert').hide();
        $('#codeAlert').hide();

        $('.desc-input').each(function(i) {
            descValue = $(this).val();
            
            if (descValue != "") {
                console.log("descValue: " + i + " " + descValue);
                matchingCode = $("#codeInput" + i).val();
                console.log("mc: " + matchingCode);
                
                if (matchingCode == "") {
                    $("#codeInput" + i).addClass('blank-field');
                    codeValid = false;
                }
            }
        });

        $('.code-select').each(function(i) {
            codeValue = $(this).val();
           
            if (codeValue != "") {
                console.log("codeValue: " + codeValue);
                matchingDesc = $("#descriptionInput" + i).val().trim();
                console.log("md: " + matchingDesc);
                 
                if (matchingDesc == "") {
                    $("#descriptionInput" + i).addClass('blank-field');
                    descValid = false;
                }
            }
        });

        if (descValid && codeValid) {
            $('#timeLogForm').find(':input').prop('disabled', false);
            $('#timeLogForm').submit();
        } else {
            alert("Please ensure entered logs have both an activity code and description.");
            e.preventDefault(e);
            return false;
        }
    });

    // Toggle inactive switch on employee/position pages
    $("#inactiveSwitch").click(function() {
        var isChecked = $(this).prop('checked');
        if (isChecked) {
            $('.emp-card.inactive').show();
        } else {
            $('.emp-card.inactive').hide();
        }
    });

    $(".submit-btn").click(function() {
        var parentId = $(this).parents('.timelog').attr('id');
        //var currentCode = $(parentId).val();
        //var currentDesc = $(parentId).val();

        var parentCount = parseInt(parentId.split("-")[1]);
        var currentCode = $("#codeInput" + parentCount).val();
        var currentDesc = $("#descriptionInput" + parentCount).val();
        var nextParent = parentCount + 1;

        console.log(currentCode);
        console.log(currentDesc);

        $("#alertDanger" + parentCount).hide();
        if (currentCode == null || currentDesc == null) {
            $("#alertDanger" + parentCount).show();
        } else {
            $('#timelog-' + nextParent).show();
        }
    });
});

function addEmployeeModal() {
    $('#addEmployeeModal').modal();
}

function addEmployee() {
    $("#employeeBtn").click(function() {
        $("#addEmployeeForm").submit();
    });
}

function openSigModal() {
    $('#signatureModal').modal();
}

function toggleEmployeePanel() {
    $('.employee-collapse-toggle').click(function() {
        var buttonCount = $(this).attr('data-count');
        var selectedPanel = '#employee-collapse-' + buttonCount;
        var isPanelShowing = $(selectedPanel).hasClass('show');

        if (isPanelShowing) {
            $(selectedPanel).removeClass('show');
        } else {
            $(selectedPanel).addClass('show');
        }
    });
}

function filterEmployeeByPos() {
    $('.position-select').change(function() {
        var positionId = $(this).val();
        window.location.href = "./position?id=" + positionId;
    });

    $('.position-select-data').change(function() {
        var positionId = $(this).val();
        window.location.href = "./agency-data?id=" + positionId;
    });
}

/*function addTimeLog() {
    var latestTimeLog = $('.timelog').last();
    var latestCount = parseInt(latestTimeLog.attr("data-count"));

    if (latestCount < 47) {
        $('.timelog').last().clone().appendTo(".logs");
        var newCount = latestCount + 1;
        $('.timelog').last().attr("id", "timelog-" + newCount);
        $('.timelog').last().attr("data-count", newCount);

        $('.timelog').last().find(".time-select").attr("id", "timeInput" + newCount);
        $('.timelog').last().find(".time-select").attr("name", "time" + newCount);
        $('.timelog').last().find(".time-select").prop("selectedIndex", newCount);

        $('.timelog').last().find(".code-select").attr("id", "codeInput" + newCount);
        $('.timelog').last().find(".code-select").attr("name", "code" + newCount);

        $('.timelog').last().find(".desc-input").attr("id", "descriptionInput" + newCount);
        $('.timelog').last().find(".desc-input").attr("name", "description" + newCount);
        $('.timelog').last().find(".desc-input").val("");

        $('.delete-btn').hide();
        $('.delete-btn').last().attr("id", "deleteBtn" + newCount);
        $('.delete-btn').last().show();
    } else {
        alert('Maximum logs for day reached.');
        $('.add-log').hide();
    }
}*/

function createTimeLogs() {
    var newCount = 1;
    while (newCount < 48) {
        $('.timelog').last().clone().appendTo(".logs");

        $('.timelog').last().attr("id", "timelog-" + newCount);
        $('.timelog').last().attr("data-count", newCount);

        $('.timelog').last().find(".time-select").attr("id", "timeInput" + newCount);
        $('.timelog').last().find(".time-select").attr("name", "time" + newCount);
        $('.timelog').last().find(".time-select").prop("selectedIndex", newCount);

        $('.timelog').last().find(".code-select").attr("id", "codeInput" + newCount);
        $('.timelog').last().find(".code-select").attr("name", "code" + newCount);

        $('.timelog').last().find(".desc-input").attr("id", "descriptionInput" + newCount);
        $('.timelog').last().find(".desc-input").attr("name", "description" + newCount);
        $('.timelog').last().find(".desc-input").val("");

        $('.timelog').last().find(".alert-danger").attr("id", "alertDanger" + newCount);

        $('.delete-btn').hide();
        $('.delete-btn').last().attr("id", "deleteBtn" + newCount);
        $('.delete-btn').last().show();

        newCount++;
    }
}