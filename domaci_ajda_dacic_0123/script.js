// ucitavanje pitanja koje se poziva onload u qiz.php
function loadQuestions() {
    $.ajax({
        type: "POST",
        url: "quiz.php",
        data: {
            load: true
        },
        success: function(response) {
            var quizContainer = document.getElementById("quiz-main");
            quizContainer.innerHTML = response;
        }
    });
}

// kupljenje odgovora i
function submitQuiz() {
    var userAnswers = {};
    var answerForms = document.getElementsByClassName("answers");

    // Iteriranje kroz svaki set odgovora kako bi se pokupili odabrani odgovori
    for (var i = 0; i < answerForms.length; i++) {
        var form = answerForms[i];
        var inputs = form.getElementsByTagName("input");

        for (var j = 0; j < inputs.length; j++) {
            if (inputs[j].checked) {
                userAnswers[i] = inputs[j].value;
                break;
            }
        }
    }

    // salje odgovore u quiz.php da ih provjer i prikaze
    $.ajax({
        type: "POST",
        url: "quiz.php",
        data: {
            submit_quiz: true,
            user_answers: userAnswers
        },
        success: function(response) {
            document.getElementById("quiz-main").innerHTML = response;
        }
    });
}
