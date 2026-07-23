const express = require('express');
const cors = require('cors');

const app = express();

// 1. Setup middleware
app.use(cors()); // Allows Vue to connect
app.use(express.json()); // Allows the API to read JSON data from Axios POST requests

// 2. Create a temporary database in memory (Just like db.json)
let users = [
  { id: 1, name: "Leanne", email: "leanne@example.com", password: "111" }
];

// 3. Create a GET route (For logging in)
app.get('/users', (req, res) => {
  // If Vue sends ?email=...&password=... we filter the list
  const { email, password } = req.query;
  
  if (email && password) {
    const matchedUser = users.filter(u => u.email === email && u.password === password);
    return res.json(matchedUser); // Send back the match
  }

  // Otherwise, just send all users
  res.json(users);
});

// 4. Create a POST route (For signing up)
app.post('/users', (req, res) => {
  const newUser = {
    id: users.length + 1,
    name: req.body.name,
    email: req.body.email,
    password: req.body.password
  };
  
  users.push(newUser); // Save to our array
  res.status(201).json(newUser); // Send success response back to Vue
});

// 5. Start the server
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Real API is now running on http://localhost:${PORT}`);
});