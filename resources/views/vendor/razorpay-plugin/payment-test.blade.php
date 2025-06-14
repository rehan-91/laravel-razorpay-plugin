<!DOCTYPE html>
<html>
<head>
  <title>Razorpay Test</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
  <h2>Test Razorpay Payment</h2>

  <form id="payment-form">
    <label>Amount (INR):</label>
    <input type="number" id="amount" value="500" min="1">
    <button type="submit">Pay</button>
  </form>

  <script>
    document.getElementById("payment-form").addEventListener("submit", function (e) {
      e.preventDefault();

      const amount = document.getElementById("amount").value;

      fetch('/razorpay/initiate', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ amount: amount })
      })
      .then(res => res.json())
      .then(res => {
        const options = {
          key: "{{ config('razorpay.key') }}",
          amount: res.data.amount,
          currency: res.data.currency,
          order_id: res.data.order_id,
          handler: function (response) {
            fetch('/razorpay/verify', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
              },
              body: JSON.stringify(response)
            })
            .then(res => res.json())
            .then(res => {
              alert(res.message || 'Verified');
            });
          }
        };

        const rzp = new Razorpay(options);
        rzp.open();
      });
    });
  </script>
</body>
</html>
