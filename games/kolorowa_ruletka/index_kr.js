const wrappers = document.querySelectorAll('.wrapper');
const btnPlay = document.querySelector('.play');
const btnReset = document.querySelector('.reset');
const btnSave = document.querySelector('.save');
const btnOut = document.querySelector('.out');
const attempts = document.querySelector('.attempts')
const money = document.querySelector('.money');
const inputData = document.querySelector('input');

function useFetchedData(data) {
    const numbers = {
        attemptsAmount: Number(data.attemptsAmount),
        moneyAmount: Number(data.moneyAmount),
    }

    let isButtonActive = true;

    attempts.textContent = numbers.attemptsAmount;
    money.textContent = numbers.moneyAmount;

    function wallet(bid, sign, multiply = false) {
        if (sign === '+') {
            if (multiply) {
                numbers.moneyAmount += bid * multiply;
            } else {
                numbers.moneyAmount += bid;
            }
        }

        if (sign === '-') {
            numbers.moneyAmount -= bid;
        }

        money.textContent = numbers.moneyAmount;
    }

    function draw(i) {
        const colors = ['0', 'f'];

        const red = Math.floor(Math.random() * colors.length);
        const green = Math.floor(Math.random() * colors.length);
        const blue = Math.floor(Math.random() * colors.length);

        wrappers[i].style.backgroundColor = `#${colors[red]}${colors[green]}${colors[blue]}`;
    }

    function play() {
        if (isButtonActive) {
            btnPlay.textContent = 'Graj';
            const bid = Number(inputData.value);

            if (inputData.value === '') {
                return alert('Nie podałeś stawki!');
            } else if (bid === 0) {
                return alert('Podaj liczbę inną niż 0.')
            }

            if (isNaN(bid)) return alert('To nie jest liczba!');
            if (numbers.moneyAmount < bid) return alert('Podałeś stawkę wyższą od wartości posiadanych pieniędzy!');

            numbers.attemptsAmount++;
            attempts.textContent = numbers.attemptsAmount;

            wrappers.forEach(wrapper => {
                wrapper.style.backgroundColor = '#fff';
            });

            setTimeout(() => draw(0), 200);
            setTimeout(() => draw(1), 400);
            setTimeout(() => draw(2), 600);
            setTimeout(() => draw(3), 800);

            setTimeout(() => {
                const wrapper0 = wrappers[0].style.backgroundColor;
                const wrapper1 = wrappers[1].style.backgroundColor;
                const wrapper2 = wrappers[2].style.backgroundColor;
                const wrapper3 = wrappers[3].style.backgroundColor;

                if ((wrapper0 === wrapper1) && (wrapper2 === wrapper3) && (wrapper0 === wrapper2)) {
                    wallet(bid, '+', 10);
                } else if ((wrapper0 === wrapper1) && (wrapper2 === wrapper3) || (wrapper0 === wrapper2) && (wrapper1 === wrapper3)) {
                    wallet(bid, '+', 5);
                } else if ((wrapper0 === wrapper1) || (wrapper2 === wrapper3) || (wrapper0 === wrapper2) || (wrapper1 === wrapper3)) {
                    wallet(bid, '+');
                } else {
                    wallet(bid, '-');
                }

                if (numbers.moneyAmount === 0) {
                    alert('Przegrałeś wszystkie środki!');
                    isButtonActive = false;
                    btnPlay.textContent = 'Zagraj ponownie';
                    numbers.attemptsAmount = 0;
                    numbers.moneyAmount = 10;
                    attempts.textContent = numbers.attemptsAmount;
                    money.textContent = numbers.moneyAmount;
                    inputData.value = '';
                    inputData.disabled = true;
                }
            }, 800);
        }

        isButtonActive = true;
        inputData.disabled = false;
        btnPlay.textContent = 'Graj';
    }

    function reset() {
        const confirmation = confirm('Czy na pewno chcesz zresetować wyniki gry?');

        if (confirmation) {
            numbers.attemptsAmount = 0;
            numbers.moneyAmount = 10;
            attempts.textContent = numbers.attemptsAmount;
            money.textContent = numbers.moneyAmount;
        } else return;
    }

    function save() {
        const confirmation = confirm('Czy na pewno chcesz zapisać wyniki gry?');

        if (confirmation) {
            fetch('../../kr_save.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(numbers),
            })
                .then(res => {
                    if (!res.ok) throw new Error('Wystąpił błąd podczas przesyłania danych.');
                    return res.text();
                })
                .then(data => {
                    if (data) throw new Error(data);
                })
                .catch(err => {
                    console.error(err);
                    alert(err);
                });
        } else return;
    }

    function out() {
        const confirmation = confirm('Czy na pewno chcesz opuścić grę?');

        if (confirmation) {
            location.href = '../../games.php';
        } else return;
    }

    btnPlay.addEventListener('click', play);
    btnReset.addEventListener('click', reset);
    btnSave.addEventListener('click', save);
    btnOut.addEventListener('click', out);
}

fetch('../../kr_data.php')
    .then(res => res.json())
    .then(data => useFetchedData(data))
    .catch(() => {
        alert('Nie pobrano danych z serwera.');
        console.error('Nie pobrano danych z serwera.');
    });