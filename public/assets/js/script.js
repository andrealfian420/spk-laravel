const verifyImage = (image) => {
    const allowedFileTypes = ["image/jpg", "image/jpeg", "image/png"];
    const maxSize = 2097152;

    if (!allowedFileTypes.includes(image.type)) {
        Swal.fire({
            icon: "error",
            title: "Terjadi kesalahan",
            text: "Harap upload file gambar ber-ekstensi jpg, jpeg atau png!",
        });

        return false;
    }

    if (image.size > maxSize) {
        Swal.fire({
            icon: "error",
            title: "Terjadi kesalahan",
            text: "Ukuran maksimal file adalah 2MB!",
        });

        return false;
    }

    return true;
};

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

const postTitle = document.querySelector("#title");
const postSlug = document.querySelector("#slug");

if (postTitle) {
    postTitle.addEventListener("change", function () {
        let slug = this.value;

        slug = slug.replace(/^\s+|\s+$/g, "");
        slug = slug.toLowerCase();

        // remove accents, swap ñ for n, etc
        let from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
        let to = "aaaaaeeeeeiiiiooooouuuunc------";
        for (let i = 0, l = from.length; i < l; i++) {
            slug = slug.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
        }

        slug = slug
            .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
            .replace(/\s+/g, "-") // collapse whitespace and replace by -
            .replace(/-+/g, "-"); // collapse dashes

        postSlug.value = slug;
    });
}

const btnDelete = document.querySelectorAll(".btnDelete");

if (btnDelete) {
    btnDelete.forEach((btn) => {
        btn.addEventListener("click", function (event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure want to delete this post?",
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

const postImg = document.querySelector("#postImg");
const prevImg = document.querySelector("#prevImg");

if (postImg) {
    postImg.addEventListener("change", function (e) {
        const image = e.target.files[0];

        const isImage = verifyImage(image);

        if (isImage) {
            return (prevImg.src = URL.createObjectURL(image));
        }

        postImg.value = "";
        return (prevImg.src =
            "https://via.placeholder.com/728x250.png?text=No+image+chosen");
    });
}

const btnDeleteCategory = document.querySelectorAll(".btnDeleteCategory");

if (btnDeleteCategory) {
    btnDeleteCategory.forEach((btn) => {
        btn.addEventListener("click", function (event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "All post within this category will also be deleted!",
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
