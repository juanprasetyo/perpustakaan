$(document).ready(function () {
    // Ajax pinjam buku
    $('.btn-pinjam').on('click', function () {
        $.ajax({
            type: "POST",
            url: baseurl + "actionPinjam",
            dataType: "JSON",
            data: {
                'book_id': $(this).attr('id'),
                'user_id': $('.id-user').val(),
                'jumlah_dipinjam': $(this).attr('jumlah')
            }
        }).done(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil...',
                text: 'Buku berhasi dipinjam!'
            })
                .then(() => {
                    location.reload();
                })
        })
    })

    // Ajax kembalikan buku
    $('.btn-return').on('click', function () {
        $.ajax({
            type: "POST",
            url: baseurl + "kembalikan",
            dataType: "JSON",
            data: {
                'book_id': $(this).attr('id'),
                'user_id': $('.id-user').val(),
                'jumlah_dipinjam': $(this).attr('jumlah')
            }
        }).done(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil...',
                text: 'Buku telah dikembalikan.'
            }).then(() => {
                location.reload();
            })
        })
    })
})

$('#inputCheckBook').iCheck({
    checkboxClass: 'icheckbox_minimal form-check-input',
    radioClass: 'iradio_minimal',
});

$('body').on('ifChecked ifUnchecked', '[name="inputCheckBook"]', function (event) {
    if (event.type == 'ifChecked') {
        $('.btn-addBook').prop('disabled', false);
    } else {
        $('.btn-addBook').prop('disabled', true);
    }
})

// Js form validation add book
// $('#add-book').parsley();


// Tambah buku
$('body').on('click', '.btn-addBook', function () {
    let dataBook = new FormData();
    let bookName = $('[name="inputBookName"]').val(),
        bookWriter = $('[name="inputBookWriter"]').val(),
        bookPublisher = $('[name="inputBookPublisher"]').val(),
        numberOfBooks = $('[name="inputNumberOfBooks"]').val(),
        imageBook = $('[name="inputImageBook"]').prop("files")[0];
    dataBook.append('bookName', bookName);
    dataBook.append('bookWriter', bookWriter);
    dataBook.append('bookPublisher', bookPublisher);
    dataBook.append('numberOfBooks', numberOfBooks);
    dataBook.append('imageBook', imageBook);

    const swalButton = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-1",
            cancelButton: "btn btn-danger mx-1",
        },
        buttonsStyling: false,
    });
    if ($("#add-book")
        .find('[required=""]')
        .map((i, v) => $(v).val())
        .toArray()
        .includes("")
    ) {
        console.log('ada yang kosong')
        formValidation();
    } else {
        swalButton
            .fire({
                'title': 'Apakah anda yakin?',
                'text': 'Buku akan ditambahkan!',
                'icon': 'warning',
                'showCancelButton': true,
                'confirmButtonText': 'Ya, Tambahkan!',
                'cancelButtonText': 'Tidak, Batalkan!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: baseurl + "addBook",
                        processData: false,
                        contentType: false,
                        data: dataBook,
                        dataType: "JSON",
                    }).done(() => {
                        swalButton
                            .fire("Updated!", "Data berhasi diupdate.", "success")
                    }).fail(() => {
                        swalButton.fire(
                            "Error!",
                            "Data gagal diupdate.",
                            "warning"
                        )
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalButton.fire(
                        "Cancelled",
                        "Data tidak diupdate :)",
                        "error"
                    )
                };
            })
    }
})


// Book Line Chart
let canvas = $('#booksLineChart');

if (window.location.href.includes('perpustakaan/grafik')) {
    console.log('jajan');
    function update() {
        $.ajax({
            method: 'GET',
            dataType: 'json',
            url: baseurl + 'dataGrafik',
            success: function (resp) {
                console.log(resp.dipinjam)
                let chart = new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: resp.judul,
                        datasets: [{
                            label: 'Buku Tersisa',
                            backgroundColor: 'red',
                            borderColor: 'red',
                            data: resp.banyak,
                            fill: false
                        }, {
                            label: 'Buku Dipinjam',
                            backgroundColor: 'yellow',
                            borderColor: 'yellow',
                            data: resp.dipinjam,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Data Peminjaman',
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Judul Buku'
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Banyak Buku'
                                },
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                })
            },
        })
        window.setTimeout(update, 10000);
    }
    update();
}




function formValidation() {
    console.log('validation jalan')
    let inputBookName = $('[name="inputBookName"]'),
        inputBookWriter = $('[name="inputBookWriter"]'),
        inputBookPublisher = $('[name="inputBookPublisher"]'),
        inputNumberOfBooks = $('[name="inputNumberOfBooks"]'),
        inputImageBook = $('[name="inputImageBook"]');

    if (inputBookName.val() == "") {
        inputBookName.after('<small class="text-danger error-name">This field must be fill.</small>');
    } else {
        inputBookName.find('.error-name').remove();
    }
    if (inputBookWriter.val() == "") {
        inputBookWriter.after('<small class="text-danger">This field is required.</small>');
    }
    if (inputBookPublisher.val() == "") {
        inputBookPublisher.after('<small class="text-danger">This field is required.</small>');
    }
    if (inputNumberOfBooks.val() == "") {
        inputNumberOfBooks.after('<small class="text-danger">This field is required.</small>');
    }
    if (inputImageBook.val() == "") {
        inputImageBook.after('<small class="text-danger">This field is required.</small>');
    }
}

// if ($('#mdlAddBook').hasClass('show')) {
//     console.log('muncul')
//     formValidation();
// }