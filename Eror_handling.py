def divide_numbers():
    try:
        numerator = int(input("Enter numerator: "))
        denominator = int(input("Enter denominator: "))
        result = numerator / denominator
    except ValueError:
        print("Error: Please enter valid integers.")
    except ZeroDivisionError:
        print("Error: Division by zero is not allowed.")
    except Exception as e:
        print(f"An unexpected error occurred: {e}")
    else:
        print(f"Result of division: {result}")
    finally:
        print("Execution of the division operation is complete.")

# Run the function
divide_numbers()
