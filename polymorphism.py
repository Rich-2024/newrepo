class Dog:
    def speak(self):
        return "Woof!"

class Cat:
    def speak(self):
        return "Meow!"

class Cow:
    def speak(self):
        return "Moo!"

# Function that demonstrates polymorphism
def animal_sound(animal):
    print(animal.speak())

# Creating instances
dog = Dog()
cat = Cat()
cow = Cow()

# Calling the function with different types of animals
animal_sound(dog)  # Output: Woof!
animal_sound(cat)  # Output: Meow!
animal_sound(cow)  # Output: Moo!
