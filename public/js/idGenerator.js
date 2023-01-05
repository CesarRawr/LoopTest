const url = 'http://localhost/prestamos/';

const fetchDevices = (callback) => {
	fetch(url+'public/php/add-loan/getDevices.php')
    .then(response => response.json())
    .then(data => {
    	callback(data.devices);
    })
    .catch(err => {
      console.log(err);
    });
}

const makeRandomId = (length) => {
	let result = '';
  	const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  	for (let i = 0; i < length; i++ ) {
    	result += characters.charAt(Math.floor(Math.random() * characters.length));
	}

	return result;
}

const createID = (devices) => {
	let id = makeRandomId(4);
	const isUsed = devices.filter((item) => item.id === id);
	if (!isUsed.length) {
		return id;
	}

	console.log("Repetido");
	createID(devices);
}

const btnGenerator = document.querySelector('.generator');
btnGenerator.addEventListener('click', (e) => {
	fetchDevices((devices) => {
		const id = createID(devices);
		const idInput = document.querySelector('#id');
		idInput.value = id;
	});
});
