# Product Requirement Document

## Requirements Feature 1

Your task is to create a Laravel application using an API & MySQL for the backend and Vue.js  and Tailwind CSS for the frontend.

- The application should have one page
- Input field which allows users to enter a hand of cards
  - Each card should be separated by a space
    - Example: `2 4 6 J K A`
- Valid cards are: `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `J`, `Q`, `K`, `A`
- A `Random` button, when this is clicked a random number of valid cards separated by space fills the input field
- A `Play` button, when this is clicked a random hand of cards with the same amount of cards that the user entered should be generated and displayed to the user.
- The user’s hand of cards should then be compared to the generated hand of cards. Each card in the player’s hand should be compared to the card in the same position in the generated hand. Highest value card wins. For example:
  - Player’s hand: `5 7 A K`
  - Generated Hand: `4 8 K Q`
- A score should be calculated for the player and generated hand, in this example it would be:
  - Player: `3`
  - Generated: `1`
  - | | Card #1 | Card #2 | Card #3 | Card #4 |
    | --- | --- | --- | --- | --- |
    | User | 5 | 7 | A | K |
    | Game | 4 | 8 | K | Q |
    | Winner | User | Game | User | User |
- The results of the game should then be shown to the user
- The results should also be stored in the database, each row should represent one play this should include **at least**:
  - the user’s ID,
  - the user’s score
  - the generated hand score
  - result of the play
  - timestamps
  - **Example**:
    - | user_id | user_score | game_score | user_won | created_at | updated_at |
      | --- | --- | --- | --- | --- | --- |
      | 1 | 3 | 4 | 0 | 2022-04-01 12:00:00 | 2022-04-01 12:00:00 |
- A paginated leaderboard should be shown at the bottom of page with **at least**:
  - position in the leaderboard
  - each user’s name
  - the total number of games
  - total number of hands that they have won
  - first game date
  - latest game date
  - **Example**:
    - | # | User | Total Games | Won Games | Latest won game | Latest lost game |
      | --- | --- | --- | --- | --- | --- |
      | 1 | John | 10 | 2 | March 4th 2022 | March 4th 2022 |
      | 2 | Mary | 7 | 5 | January 1st 2021 | March 1st 2022 |
- Validation should be included on the API. Any validation messages should be displayed to the user
  - for instance, to ensure that all of the cards are valid.

## Requirements Bonus Feature 2

- Create endpoints to retrieve statistics:
  - Current week's leaderboards (top 10)
  - Current month's leaderboard (top 10)
  - All-time leaderboard (top 10)
  - All-time average card hand size
  - All-time total number of plays
  - All-time total number of cards played by humans,
  - All-time best and worst score humans VS game
  - All-time best human hand