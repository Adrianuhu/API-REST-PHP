db = db.getSiblingDB('appdb');
db.createUser({
  user: "app",
  pwd: "app_password",
  roles: [
    { role: "readWrite", db: "appdb" }
  ]
});

db.createCollection('users');

db.users.insertMany([
  { username: "User1", password: "pass1" },
  { username: "User2", password: "pass2" },
  { username: "User3", password: "pass3" },
  { username: "User4", password: "pass4" },
  { username: "User5", password: "pass5" }
]);
