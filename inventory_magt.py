import os

# File to save inventory data
FILENAME = "inventory.txt"
OWNER_NAME = "Richard Ogwal"

# Load inventory from file
def load_inventory():
    inventory = {}
    if os.path.exists(FILENAME):
        with open(FILENAME, "r") as file:
            for line in file:
                item, quantity = line.strip().split(',')
                inventory[item] = int(quantity)
    return inventory

# Save inventory to file
def save_inventory(inventory):
    with open(FILENAME, "w") as file:
        for item, quantity in inventory.items():
            file.write(f"{item},{quantity}\n")

def display_inventory(inventory):
    print(f"\n--- {OWNER_NAME}'s Inventory ---")
    if not inventory:
        print("Inventory is empty.")
    else:
        for item, quantity in inventory.items():
            print(f"{item}: {quantity} units")
    print("-------------------------------\n")

def add_item(inventory):
    item = input("Enter item name to add: ").capitalize()
    if item in inventory:
        print("Item already exists. Use update option to change quantity.")
    else:
        try:
            quantity = int(input(f"Enter quantity for {item}: "))
            inventory[item] = quantity
            save_inventory(inventory)
            print(f"{item} added to inventory.")
        except ValueError:
            print("Invalid quantity.")

def update_stock(inventory):
    item = input("Enter item name to update: ").capitalize()
    if item in inventory:
        try:
            quantity = int(input(f"Enter new quantity for {item}: "))
            inventory[item] = quantity
            save_inventory(inventory)
            print(f"{item} updated.")
        except ValueError:
            print("Invalid quantity.")
    else:
        print("Item not found in inventory.")

def remove_item(inventory):
    item = input("Enter item name to remove: ").capitalize()
    if item in inventory:
        del inventory[item]
        save_inventory(inventory)
        print(f"{item} removed from inventory.")
    else:
        print("Item not found.")

# Main program
def main():
    inventory = load_inventory()

    while True:
        print(f"\n{OWNER_NAME}'s Inventory Management Menu:")
        print("1. Display Inventory")
        print("2. Add New Item")
        print("3. Update Stock")
        print("4. Remove Item")
        print("5. Exit")

        choice = input("Choose an option (1-5): ")

        if choice == "1":
            display_inventory(inventory)
        elif choice == "2":
            add_item(inventory)
        elif choice == "3":
            update_stock(inventory)
        elif choice == "4":
            remove_item(inventory)
        elif choice == "5":
            print(f"Exiting {OWNER_NAME}'s Inventory Management System. Goodbye!")
            break
        else:
            print("Invalid choice. Please select a valid option.")

if __name__ == "__main__":
    main()
