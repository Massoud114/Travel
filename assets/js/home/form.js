import axios from "axios";

const travelForm = document.getElementById('travel-form')

let flights = null

travelForm.addEventListener('submit', (async e => {
	e.preventDefault()
	const suggestInputs = document.getElementsByClassName('suggest-input');
	let travelData = {
		originLocationCode: document.getElementById('originCode').value,
		destinationLocationCode: document.getElementById('destinationCode').value,
		departureDate: document.getElementById('travel-date').value,
		adults: document.getElementById('travel-adult').value,
		originCountry : suggestInputs[0].getAttribute("data-country"),
		destinationCountry : suggestInputs[1].getAttribute("data-country")
	}

	let url = "https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=" + travelData.originLocationCode + "&destinationLocationCode=" + travelData.destinationLocationCode + "&departureDate=" + travelData.departureDate.toLocaleString() + "&adults=" + travelData.adults
	flights = await axios.get(url)
		.then(r => r.data.data)
		.then(data => {
			showFlightList(data, travelData)
			return data
		})
}))

function showFlightList(flights, travelData) {
	document.getElementById("result-title").classList.remove("custom-hidden")
	document.getElementById("result-container").classList.remove("custom-hidden")
	const suggestInputs = document.getElementsByClassName('suggest-input');
	let flightList = document.getElementById("flights-list")

	let latestPrice = 0

	flights.map((flight, index) => {
		if (latestPrice != flight.price.total) {
			let element = `
			<div class="col-sm-6 col-lg-4 margin-bottom-30px">
				<div class="hotel-grid background-white border border-grey-1 with-hover">
					<div class="hotel-img position-relative">
						<img src="https://images.unsplash.com/photo-1530521954074-e64f6810b32d?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1" alt="">
						<div class="hover-option background-main-color opacity-6">
							<h3 class="text-center text-white padding-top-n-25 "></h3>
						</div>
					</div>
					<div class="padding-20px">
						<h3 class="text-uppercase text-medium"><a href="/travel/${flight.id}" class="text-dark font-weight-700">${suggestInputs[0].value}</a></h3>
						<small class="d-block text-uppercase text-extra-small margin-bottom-10px">
							<a href="#" class="text-grey-4"><i class="fa fa-chevron-up margin-right-5px"></i>
							Départ :  <span class="text-third-color margin-right-5px">${travelData.departureDate}</span> </a>
						</small><div class="claerfix"></div>
						<div class="margin-top-8px padding-top-8px text-uppercase text-extra-small border-top-1 border-grey-1">
							<strong class="text-medium text-third-color padding-right-5px font-weight-bold">${flight.price.total} ${flight.price.currency}</strong>Total
							<i class="d-block padding-tb-8px text-grey-2"><span class="margin-right-40px">${flight.oneWay ? 'Vol Direct' : 'Escale'}</span></i>
						</div>
						<form action="/travel/show" method="post">
							<input name="travel" type="hidden" value='${JSON.stringify(travelData)}'>
							<input name="flight" type="hidden" value='${JSON.stringify(flight)}'>
							<button type="submit" class="travel-button btn-sm btn-lg btn-block background-main-color text-white text-center font-weight-bold text-uppercase ">Voir les détails </button>
						</form>
					</div>
				</div>
			</div>
		`
			flightList.innerHTML += element
		}
		latestPrice = flight.price.total
	})
}


function showDetail(index) {
	console.log(index);
}
