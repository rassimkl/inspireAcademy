document.addEventListener('livewire:initialized', () => {



    Livewire.on('showAlert', function (data) {

        // Display SweetAlert modal with data received from Livewire
        Swal.fire({
            title: data[0].title,
            text: data[0].text,
            icon: data[0].icon
        });
    });




})