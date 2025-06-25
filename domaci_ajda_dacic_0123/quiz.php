<?php
// provjera odgovora i unos rezultata u bazu
global $conn;
if (isset($_POST['submit_quiz'])) {
if (isset($_SESSION['username'])) {
$username = $_SESSION['username'];
} else {
$username = 'anon';
}

$score = 0;
$hasResults = false;

if (isset($_POST['user_answers'])) {
$userAnswers = $_POST['user_answers'];
echo '<div class="quiz-container">';

    // prolazak kroz odgovore korisnika i provjera tačnosti
    foreach ($userAnswers as $questionId => $answerId) {
    $question = $conn->query("SELECT * FROM pitanja WHERE id=$questionId")->fetch_assoc();
    $answer = $conn->query("SELECT * FROM odgovori WHERE id=$answerId AND pitanje_id=$questionId")->fetch_assoc();

    $isCorrect = false;
    if ($answer && $answer['tacan'] == 1) {
    $isCorrect = true;
    }

    if ($isCorrect) {
    $score++;
    }

    echo '<div class="question-card">';
        echo '<div class="question">'.$question['pitanje'].'</div>';
        echo '<form class="answers">';

            $answers = $conn->query("SELECT * FROM odgovori WHERE pitanje_id=$questionId");
            while ($option = $answers->fetch_assoc()) {

            if ($answerId == $option['id']) {
            $isSelected = 'checked';
            } else {
            $isSelected = 'disabled';
            }

            if ($option['tacan']) {
            $style = 'style="font-weight:bold; color:green;"';
            } else {
            $style = '';
            }

            echo '<label ' . $style . '>';
            echo '<input type="radio" name="answer_' . $questionId . '" value="' . $option['id'] . '" ' . $isSelected . '>';
            echo ' ' . htmlspecialchars($option['odgovor']);
            echo '</label><br>';
            }

            echo '</form>';
        if ($isCorrect) {
        $resultText = 'Correct';
        } else {
        $resultText = 'Incorrect';
        }
        echo '<div class="result-span">' . $resultText . '</div>';
        echo '</div>';
    }

    // unos rezultata u bazu
    $conn->query("INSERT INTO rezultati (korisnicko_ime, poeni, datum) VALUES ('$username', $score, NOW())");

    } else {
    echo '<alert>You did not answer any questions</alert>';
    }

    echo '<div id="final-score" style="margin-top:10px;font-weight:bold;">Score: '.$score.'</div>';

    // ponovno učitavanje liste rezultata
    echo '<div class="leaderboard" id="leaderboard"><h2>Leaderboard</h2>';
        $resultsQuery = $conn->query("SELECT * FROM rezultati ORDER BY poeni DESC");
        if ($resultsQuery->num_rows > 0) {
        $hasResults = true;
        echo '<ol>';
            while ($result = $resultsQuery->fetch_assoc()) {
            echo '<li>'.$result['korisnicko_ime'].' - '.$result['poeni'].' points ('.$result['datum'].')</li>';
            }
            echo '</ol>';
        } else {
        echo '<p>Error loading results.</p>';
        }
        echo '</div>';

    echo '<a href="restart.php">Play again</a>';
    exit;
    }
