# 1. Output your favorite phone brand
x = ("samsung", "iphone", "tecno", "redmi")
print("1. My favorite phone brand:", x[0])  # You can change the index to your favorite

# 2. Negative indexing to print the 2nd last item
print("2. Second last item (negative index):", x[-2])

# 3. Update “iphone” to “itel” (Tuples are immutable, so we must convert to a list first)
x_list = list(x)
x_list[1] = "itel"
x = tuple(x_list)
print("3. Updated tuple (iphone to itel):", x)

# 4. Add “Huawei” to the tuple (again, use list conversion)
x_list.append("Huawei")
x = tuple(x_list)
print("4. Added Huawei:", x)

# 5. Loop through the tuple
print("5. Loop through tuple:")
for phone in x:
    print("-", phone)

# 6. Remove the first item from tuple
x_list = list(x)
del x_list[0]
x = tuple(x_list)
print("6. After deleting first item:", x)

# 7. Using tuple constructor to create a tuple of cities in Uganda
cities = tuple(["Kampala", "Gulu", "Mbale", "Mbarara", "Jinja"])
print("7. Cities in Uganda:", cities)

# 8. Unpack the tuple
a, b, c, d, e = cities
print("8. Unpacked cities:")
print("City 1:", a)
print("City 2:", b)
print("City 3:", c)
print("City 4:", d)
print("City 5:", e)

# 9. Range of indexes to print the 2nd, 3rd and 4th cities
print("9. Cities 2-4:", cities[1:4])

# 10. Join two tuples
first_names = ("John", "Mary", "Ali")
last_names = ("Doe", "Smith", "Khan")
full_names = first_names + last_names
print("10. Joined name tuples:", full_names)

# 11. Create a tuple of colors and multiply it by 3
colors = ("red", "blue", "green")
colors_multiplied = colors * 3
print("11. Colors multiplied by 3:", colors_multiplied)

# 12. Count how many times 8 appears
thistuple = (1, 3, 7, 8, 7, 5, 4, 6, 8, 5)
count_8 = thistuple.count(8)
print("12. Number of times 8 appears:", count_8)
