document.addEventListener('livewire:initialized', () => {



    Livewire.on('showAlert', function (data) {

        // Display SweetAlert modal with data received from Livewire
        Swal.fire({
            title: data[0].title,
            text: data[0].text,
            icon: data[0].icon
        });
    });

    Livewire.on('confirmTask', (messagevalue) => {
        const [message, listner] = messagevalue;
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, call the Livewire delete method with the item ID

                Livewire.dispatch(listner);
            }
        });
    });



    Livewire.on('cancelClass', (messagevalue) => {
        const [message, listner] = messagevalue;
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, call the Livewire delete method with the item ID

                Livewire.dispatch(listner);
            }
        });
    });



})