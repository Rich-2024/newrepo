class Player:
    def play(self):
        print("Player is playing on the field.")

class Goalkeeper(Player):
    def play(self):
        print("Goalkeeper is guarding the goal.")

# Usage
player = Player()
goalkeeper = Goalkeeper()

player.play()      
goalkeeper.play()   
