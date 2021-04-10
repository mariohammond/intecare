$(function() {
    var windowHeight = $(window).height();
    $('#page-fit.wrapper').css('height', windowHeight);

    $(window).resize(function() {
        var windowHeight = $(window).height();
        $('#page-fit.wrapper').css('height', windowHeight);
    });

    toggleEmployeePanel();
    filterEmployeeByPos();

    $(document).on('click', '.delete-btn', function() {
        var logCount = parseInt($(this).attr("id").slice(-1));
        $("#timelog-" + logCount).remove();

        $('.delete-btn').hide();
        $('.delete-btn').last().show();
    });

    $(".save-btn").click(function(e) {
        var descValue, codeValue;
        var descValid = true;
        var codeValid = true;

        $('#descAlert').hide();
        $('#codeAlert').hide();

        $('.desc-input').each(function() {
            descValue = $(this).val();
            if (descValue == "") {
                descValid = false;
                $('#descAlert').show();
                return false;
            }
        });

        $('.code-select').each(function() {
            codeValue = $(this).val();
            if (codeValue == "") {
                descValid = false;
                $('#codeAlert').show();
                return false;
            }
        });

        if (descValid && codeValid) {
            $('#timeLogForm').find(':input').prop('disabled', false);
            $('#timeLogForm').submit();
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

function addTimeLog() {
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
}

