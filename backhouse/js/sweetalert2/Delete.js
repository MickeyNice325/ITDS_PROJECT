
document.addEventListener('DOMContentLoaded', (event) => {
    const deleteLinks = document.querySelectorAll('.delete-btn');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            Swal.fire({
                title: 'ต้องการลบจริงหรือไม่',
                text: "คำเตือนถ้าลบจะไม่สามารถดึงข้อมูลกลับมาได้อีก",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'แม่นแล้ว!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    });
});
