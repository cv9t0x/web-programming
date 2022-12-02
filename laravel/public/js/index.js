switch (window.location.pathname) {
    case '/app/main': {
        const userInfoBlock = document.querySelector('.user-info-user-credentials');

        if (userInfoBlock) {
            userInfoBlock.addEventListener('click', (event) => {
                if (event.target.classList.contains('collapse-button')) {
                    const parentBlock = event.target.closest('.user-info--field-block');
                    Array.from(parentBlock.querySelectorAll('.user-info--hidden-block')).forEach(elem => {
                        elem.classList.toggle('none');
                    });
                }
            });
        }
        break;
    }
    case '/app/bindings': {
        const  bindingList = document.querySelector('.bindings-list');

        bindingList.addEventListener('click', (event) => {
            if (event.target.classList.contains('collapse-button')) {
                const bindingBlock = event.target.closest('.binding-block');

                if (bindingBlock) {
                    const editBlock = bindingBlock.querySelector('.binding-edit-block');
                    editBlock.classList.toggle('none')
                }
            }

            if (event.target.classList.contains('collapse-button-password')) {
                const passwordBlock = event.target.closest('.binding-password-block');

                if (passwordBlock) {
                    const showPasswordBlock = passwordBlock.querySelector('.binding-password-block--password');
                    showPasswordBlock.classList.toggle('none');
                }
            }
        })
        break;
    }
}
