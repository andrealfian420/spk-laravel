const btnSignOut = document.querySelector(".btnSignOut");

if (btnSignOut) {
    btnSignOut.addEventListener("click", function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Are you sure want to sign out?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, sign out!",
        }).then((result) => {
            if (result.isConfirmed) {
                btnSignOut.parentElement.submit();
            }
        });
    });
}

const btnDelete = document.querySelectorAll(".btnDelete");

if (btnDelete) {
    btnDelete.forEach((btn) => {
        btn.addEventListener("click", function (event) {
            const object = this.dataset.object;

            event.preventDefault();

            Swal.fire({
                title: `Are you sure want to delete this ${object}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete!",
            }).then((result) => {
                if (result.isConfirmed) {
                    btn.parentElement.submit();
                }
            });
        });
    });
}
