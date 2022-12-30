const cards = document.querySelectorAll('.card');

const cardsAnimationOver = (e) => {
	if (e.target.classList[0] === "card") {
		const cardHeader = e.target.querySelector('header');
		const cardBody = e.target.querySelector('.option-list-container');
		const icon = e.target.querySelector('.icon');

		icon.style.display = "none";
		cardHeader.style.height = '15%';

		cardBody.style.transition = 'all .35s ease-in 0.05s';
		cardBody.style.height = '85%';
	}
};

const cardsAnimationLeave = (e) => {
	if (e.target.classList[0] === "card") {
		const cardHeader = e.target.querySelector('header');
		const cardBody = e.target.querySelector('.option-list-container');
		const icon = e.target.querySelector('.icon');

		icon.style.display = "inline";
		cardBody.style.transition = 'all .1s ease-in 0s';

		cardHeader.style.height = '100%';
		cardBody.style.height = '0';
	}
};

const hoverOn = (e) => {
	e.target.style.background = 'red';
}

const hoverOff = (e) => {
	e.target.style.background = 'blue';
}

cards.forEach((card) => {
    card.addEventListener('mouseover', cardsAnimationOver);
    card.addEventListener('mouseleave', cardsAnimationLeave);
});
