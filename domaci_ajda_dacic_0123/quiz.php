<?php
global $conn;
session_start();
include "connection.php";

// ucitavanje kviza
if (isset($_POST['load'])) {
    echo '<div class="quiz-container">';

    $questionQuery = $conn->query("SELECT * FROM pitanja ORDER BY RAND() LIMIT 5");
    while ($questionRow = $questionQuery->fetch_assoc()) {
        $questionId = $questionRow['id'];
        echo '<div class="question-card">';
        echo '<div class="question">'.$questionRow['pitanje'].'</div>';
        echo '<form class="answers">';
//upit koji random redosljedom izvlaci 5 pitnja iz baze
        $answerQuery = $conn->query("SELECT * FROM odgovori WHERE pitanje_id=$questionId ORDER BY RAND()");
        while ($answerRow = $answerQuery->fetch_assoc()) {
            echo '<label><input type="radio" name="answer_'.$questionId.'" value="'.$answerRow['id'].'"> '.$answerRow['odgovor'].'</label><br>';
        }

        echo '</form>';
        echo '<div class="result-span"></div>';
        echo '</div>';
    }

    echo '<button id="submit-quiz-btn" onclick="submitQuiz()">Submit Answers</button>';
    echo '<div id="final-score" style="margin-top:10px;font-weight:bold;"></div>';

    // ucitavanje tabele rezultata
    echo '<div class="leaderboard" id="leaderboard"><h2>Leaderboard</h2>';
    $resultsQuery = $conn->query("SELECT * FROM rezultati ORDER BY poeni DESC");
    if ($resultsQuery->num_rows > 0) {
        echo '<ol>';
        while ($result = $resultsQuery->fetch_assoc()) {
            echo '<li>'.$result['korisnicko_ime'].' - '.$result['poeni'].' points ('.$result['datum'].')</li>';
        }
        echo '</ol>';
    } else {
        echo '<p>No results.</p>';
    }
    echo '</div>';
    exit;
}

// provjera odgovora i unos u bazu
if (isset($_POST['submit_quiz'])) {
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'anon';
    $score = 0;
    $hasResults = false;

    if (isset($_POST['user_answers'])) {
        $userAnswers = $_POST['user_answers'];
        echo '<div class="quiz-container">';
//provjera jesu li odgovori tacni
        foreach ($userAnswers as $questionId => $answerId) {
            $question = $conn->query("SELECT * FROM pitanja WHERE id=$questionId")->fetch_assoc();
            $answer = $conn->query("SELECT * FROM odgovori WHERE id=$answerId AND pitanje_id=$questionId")->fetch_assoc();
            $isCorrect = ($answer && $answer['tacan'] == 1);
            if ($isCorrect) $score++;

            echo '<div class="question-card">';
            echo '<div class="question">'.$question['pitanje'].'</div>';
            echo '<form class="answers">';

            $answers = $conn->query("SELECT * FROM odgovori WHERE pitanje_id=$questionId");
            while ($option = $answers->fetch_assoc()) {
                $isSelected = ($answerId == $option['id']) ? 'checked' : 'disabled';
                $style = ($option['tacan']) ? 'style="font-weight:bold;color:green;"' : '';
                echo '<label '.$style.'><input type="radio" name="answer_'.$questionId.'" value="'.$option['id'].'" '.$isSelected.'> '.$option['odgovor'].'</label><br>';
            }

            echo '</form>';
            echo '<div class="result-span">'.($isCorrect ? 'Correct' : 'Incorrect').'</div>';
            echo '</div>';
        }

        // upis rezultata
        $conn->query("INSERT INTO rezultati (korisnicko_ime, poeni, datum) VALUES ('$username', $score, NOW())");
    } else {
        echo '<alert>You did not answer any questions</alert>';
    }

    echo '<div id="final-score" style="margin-top:10px;font-weight:bold;">Score: '.$score.'</div>';

    // ponovo ucitava listu (iz nekog razloga uvijek je username isti i ako se na retart gasi sesija)
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

    // restart
    if ($hasResults){
        echo '<form method="post" action="restart.php">
        <button type="submit">Igraj ponovo</button>
      </form>';

    }
    exit;
}

// ako korisnik nema sesiju vraca ga a indeks
if (!isset($_SESSION['username'])) {
    if (isset($_POST['username'])) {
        $_SESSION['username'] = $_POST['username'];
    } else {
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <link rel="stylesheet" href="style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="script.js"></script>
</head>
<body onload="loadQuestions()">
<div id="quiz-main"></div>
</body>
</html>
