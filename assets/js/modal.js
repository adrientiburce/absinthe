let modal = null;

const openModal = function (e) {
    e.preventDefault();
    let target = document.querySelector(e.target.getAttribute('href'));
    target.style.display = null;
    target.removeAttribute('aria-hidden');
    target.setAttribute('aria-modal', true);
    modal = target;
    console.log(modal);
    modal.addEventListener('click', closeModal);
    modal.querySelector('.js-modal-close').addEventListener('click', closeModal);
    modal.querySelector('.js-modal-stop').addEventListener('click', stopPropagation);
};

const closeModal = function (e) {
    if (modal == null) return;
    e.preventDefault();
    window.setTimeout(function () {
        modal.style.display = 'none';
        modal = null;
    }, 500)
    modal.setAttribute('aria-hidden', true);
    modal.removeAttribute('aria-modal');
    modal.querySelector('.js-modal-close').removeEventListener('click', closeModal);
    modal.querySelector('.js-modal-stop').removeEventListener('click', stopPropagation);
};

const stopPropagation = function (e) {
    e.stopPropagation();
};

document.querySelectorAll('.js-modal').forEach(a => {
    a.addEventListener('click', openModal);
});

window.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' || e.key === 'Esc') {
        closeModal(e);
    }
});

function showModal(modalId) {
    let target = document.querySelector(modalId)
    target.style.display = null;
    target.removeAttribute('aria-hidden');
    target.setAttribute('aria-modal', true);
    modal = target;
    console.log(modal);
    modal.addEventListener('click', closeModal);
    modal.querySelector('.js-modal-close').addEventListener('click', closeModal);
    modal.querySelector('.js-modal-stop').addEventListener('click', stopPropagation);
}

let isPseudoModalOpen = document.querySelector('#modalPseudo').getAttribute('data-isOpen');
let isPasswordModalOpen = document.querySelector('#modalPassword').getAttribute('data-isOpen');
console.log("isModalOpen", isPseudoModalOpen);

if (isPseudoModalOpen) {
    showModal('#modalPseudo');
}
if (isPasswordModalOpen) {
    showModal('#modalPassword');
}
