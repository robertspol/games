const gameTitles = [...document.querySelectorAll('.games-list li')];
const deleteWrapper = document.querySelector('.delete-account-wrapper a');

let acd = gameTitles[0];
let kr = gameTitles[1];

function goToGame(game) {
    switch (game) {
        case acd:
            location.href = './games/aniol_czy_diabel/index_acd.html';
            break;
        case kr:
            location.href = './games/kolorowa_ruletka/index_kr.html';
            break;
        default:
            break;
    }
}

function makeCover() {
    const cover = document.createElement('div');
    cover.classList.add('games-cover');
    document.body.appendChild(cover);
}

function addClickOnGame(game) {
    game.addEventListener('click', function () {
        this.classList.add('game-link-clicked');
        makeCover();
        setTimeout(() => goToGame(game), 1000);
    });
}

addClickOnGame(acd);
addClickOnGame(kr);

deleteWrapper.addEventListener('click', function () {
    const confirmation = confirm('Czy na pewno chcesz usunąć konto?');

    if (confirmation) {
        location.href = 'account-delete.php';
    } else return;
});