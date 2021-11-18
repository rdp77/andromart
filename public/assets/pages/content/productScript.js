function del(id) {
    alert(id);
    // swal({
    //     title: "Apakah Anda Yakin?",
    //     text: "Aksi ini tidak dapat dikembalikan, dan akan menghapus kategori product dan seluruh product yang ada didalamnya",
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    // }).then((willDelete) => {
    //     if (willDelete) {
    //         $.ajax({
    //             url: "/content/product/type-product/" + id,
    //             type: "DELETE",
    //             success: function () {
    //                 swal("Kategori Produk berhasil dihapus", {
    //                     icon: "success",
    //                 });
    //                 table.draw();
    //             },
    //         });
    //     } else {
    //         swal("Kategori Produk Anda tidak jadi dihapus!");
    //     }
    // });
}
