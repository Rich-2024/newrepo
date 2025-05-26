class PaymentProcessor:
    def make_payment(self, amount, method=None, currency='USD'):
        if currency == 'UGX':
            print(f"Processing payment of {amount} UGX via {method if method else 'default method'}.")
        elif method:
            print(f"Processing payment of {amount} {currency} via {method}.")
        else:
            print(f"Processing payment of {amount} {currency} by default method.")


processor = PaymentProcessor()

processor.make_payment(100000, currency="UGX")                      # give us UGX default method
processor.make_payment(200000, method="Mobile Money", currency="UGX")  # UGX with method
processor.make_payment(50, method="Credit Card")                    # USD with method
processor.make_payment(75)                                          # USD default
