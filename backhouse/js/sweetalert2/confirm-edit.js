// js/sweetalert2/confirm-edit.js

document.addEventListener('DOMContentLoaded', (event) => {
    const forms = document.querySelectorAll('form[id^="editForm"]');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formId = this.getAttribute('id');

            Swal.fire({
                title: 'คุณแน่ใจไหม?',
                text: "คุณต้องการบันทึกการเปลี่ยนแปลงหรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'แม่นแล้ว!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        });
    });
});
