
if ("serviceWorker" in navigator) {

    window.addEventListener('load', function () {
        navigator.serviceWorker.register('http://internship-finder.fr/scripts/sw.js').then(
            function (registration) {
                console.log('registration succes with scope : ', registration.scope)
            },
            function (err) {
                console.log('errror', err)
            })

    })


}



