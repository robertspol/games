const choices = document.querySelectorAll("img");
const btnPlay = document.querySelector(".buttons__play");
const btnReset = document.querySelector(".buttons__reset");
const btnSave = document.querySelector(".buttons__save");
const btnOut = document.querySelector(".buttons__out");

const winner = document.querySelector(".winner");
const gamesNumber = document.querySelector(".results__games-number");
const wins = document.querySelector(".results__wins");
const failures = document.querySelector(".results__failures");
const draws = document.querySelector(".results__draws");

const yourChoice = document.querySelector(".results__your-choice");
const aiChoice = document.querySelector(".results__computer-choice");

const finalTextWrapper = document.createElement("div");

let yourChoiceForFinalText = "";
let aiChoiceForFinalText = "";

function useFetchedData(data) {
    const game = {
        games: data.games,
        wins: data.wins,
        failures: data.failures,
        draws: data.draws,
    };

    const selected = {
        playerChoice: null,
        aiChoice: null,
    };

    gamesNumber.textContent = game.games;
    wins.textContent = game.wins;
    failures.textContent = game.failures;
    draws.textContent = game.draws;

    function randomForAi() {
        const index = Math.floor(Math.random() * choices.length);
        return choices[index];
    }

    function computerChoice() {
        const drawResult = randomForAi();
        selected.aiChoice = drawResult.dataset.option;
        aiChoiceForFinalText = drawResult.getAttribute("name");
        aiChoice.textContent = drawResult.getAttribute("name");
    }

    function selectingWinner(playerChoice, aiChoice) {
        if (playerChoice && aiChoice) {
            if (playerChoice === "angel" && aiChoice === "devil")
                return "playerWin";
            else if (playerChoice === "angel" && aiChoice === "doubts")
                return "compWin";
            else if (playerChoice === "devil" && aiChoice === "angel")
                return "compWin";
            else if (playerChoice === "devil" && aiChoice === "doubts")
                return "playerWin";
            else if (playerChoice === "doubts" && aiChoice === "angel")
                return "playerWin";
            else if (playerChoice === "doubts" && aiChoice === "devil")
                return "compWin";
            else if (playerChoice === aiChoice) return "draw";
        }
    }

    function finalResults(result) {
        gamesNumber.textContent = ++game.games;

        if (result === "playerWin") {
            winner.textContent = "Zwycięzca gry: ty!";
            wins.textContent = ++game.wins;
        } else if (result === "compWin") {
            winner.textContent = "Zwycięzca gry: komputer!";
            failures.textContent = ++game.failures;
        } else if (result === "draw") {
            winner.textContent = "Zwycięzca gry: remis!";
            draws.textContent = ++game.draws;
        }

        choices.forEach((choice) => choice.removeEventListener("click", start));
        btnPlay.classList.remove("play-clicked");
        description();
    }

    function start() {
        this.style.boxShadow = "0 0 10px 4px #f00";
        selected.playerChoice = this.dataset.option;
        yourChoiceForFinalText = this.getAttribute("name");
        yourChoice.textContent = this.getAttribute("name");
        computerChoice();

        const result = selectingWinner(
            selected.playerChoice,
            selected.aiChoice
        );

        finalResults(result);
    }

    function description() {
        finalTextWrapper.classList.add("final-text");
        finalTextWrapper.style.display = "block";

        finalTextWrapper.innerHTML = `
        <p class="final-text__you">Twoja postać: ${yourChoiceForFinalText}</p>
        <p class="final-text__comp">Postać komputera: ${aiChoiceForFinalText}</p>
        <p>${winner.textContent}</p>
        `;

        document.body.appendChild(finalTextWrapper);
    }

    function play() {
        choices.forEach((choice) => (choice.style.boxShadow = ""));
        btnPlay.classList.add("play-clicked");
        finalTextWrapper.textContent = "";
        finalTextWrapper.style.display = "none";

        choices.forEach((choice) => choice.addEventListener("click", start));
    }

    function reset() {
        const confirmation = confirm(
            "Czy na pewno chcesz zresetować wyniki gry?"
        );

        if (confirmation) {
            choices.forEach((choice) => (choice.style.boxShadow = ""));

            game.games = 0;
            game.wins = 0;
            game.failures = 0;
            game.draws = 0;
            selected.playerChoice = null;
            selected.aiChoice = null;

            yourChoice.textContent = "";
            aiChoice.textContent = "";
            winner.textContent = "Zwycięzca gry: ";
            gamesNumber.textContent = game.games;
            wins.textContent = game.wins;
            failures.textContent = game.failures;
            draws.textContent = game.draws;

            finalTextWrapper.textContent = "";

            if (btnPlay.classList.contains("play-clicked")) {
                btnPlay.classList.remove("play-clicked");
            }
        }
    }

    function save() {
        const confirmation = confirm("Czy na pewno chcesz zapisać wyniki gry?");

        if (confirmation) {
            fetch("../../php/actions/save-data-acd-action.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(game),
            })
                .then((res) => {
                    if (!res.ok)
                        throw new Error(
                            "Wystąpił błąd podczas przesyłania danych."
                        );
                    // return res.text();
                })
                // .then((data) => {
                //     if (data) throw new Error(data);
                // })
                .catch((err) => {
                    console.error(err);
                    alert(err);
                });
        } else return;
    }

    function out() {
        const confirmation = confirm("Czy na pewno chcesz opuścić grę?");

        if (confirmation) {
            location.href = "../../php/games.php";
        } else return;
    }

    btnPlay.addEventListener("click", play);
    btnReset.addEventListener("click", reset);
    btnSave.addEventListener("click", save);
    btnOut.addEventListener("click", out);
}

fetch("../../php/actions/get-data-acd-action.php")
    .then((res) => res.json())
    .then((data) => useFetchedData(data))
    .catch(() => {
        alert("Nie pobrano danych z serwera.");
        console.error("Nie pobrano danych z serwera.");
    });
