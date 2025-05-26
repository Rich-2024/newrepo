class Player:
    def play_style(self):
        print("Generic player style.")

class Striker(Player):
    def play_style(self):
        print("Plays aggressively, aiming to score goals.")

class Captain(Player):
    def play_style(self):
        print("Leads the team and motivates others.")

class StrikerCaptain(Striker, Captain):
    pass

# Create instance
star_player = StrikerCaptain()
star_player.play_style()  # ,shows  play_style is used?

# Show Method Resolution Order
print(StrikerCaptain.__mro__)
