<div>
    <label for="card" class="block text-sm font-medium text-gray-700 leading-5">
        Payment Information
    </label>
    <div class="mt-1 rounded-md shadow-sm">
        <div id="card-element" class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 appearance-none roudned-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"></div>
        <div id="card-errors" class="mt-2 text-sm text-red-600"></div>
    </div>
</div>
@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
// Create a Stripe client.
const stripe = Stripe('{{ config('services.stripe.key') }}');
const elements = stripe.elements();
const cardElement = elements.create('card');
const clientSecret = "{{ $intent->client_secret }}";
const cardholderName = document.getElementById('name');
const cardButton = document.getElementById('cardbutton');
const paymentMethodInput = document.getElementById('paymentMethodInput');

cardElement.mount("#card-element");

cardButton.addEventListener('click', async (e) => {

    e.preventDefault();
    const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: { name: cardholderName.value }
            }
        }
    );

    if (error) {
        console.log("there was an error");
        console.log(error);
    } else {
        const paymentMethod = setupIntent.payment_method;
        paymentMethodInput.value = paymentMethod;
        document.getElementById('registration').submit();
    }
});

</script>
@endpush
