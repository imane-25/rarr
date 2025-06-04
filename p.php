<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paiement en ligne</title>
  <style>
    :root {
      --primary-color: #4a6bff;
      --secondary-color: #f8f9fa;
      --text-color: #333;
      --border-color: #ddd;
      --error-color: #e74c3c;
      --success-color: #2ecc71;
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background-color: #f5f5f7;
      color: var(--text-color);
      line-height: 1.6;
      padding: 20px;
    }
    
    .container {
      max-width: 600px;
      margin: 30px auto;
      padding: 30px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    h2 {
      color: var(--primary-color);
      margin-bottom: 20px;
      text-align: center;
      font-weight: 600;
    }
    
    .payment-methods {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 25px;
    }
    
    .payment-methods img {
      width: 50px;
      height: auto;
      transition: transform 0.3s;
    }
    
    .payment-methods img:hover {
      transform: scale(1.1);
    }
    
    form {
      display: grid;
      gap: 20px;
    }
    
    .form-group {
      display: flex;
      flex-direction: column;
    }
    
    label {
      margin-bottom: 8px;
      font-weight: 500;
      color: #555;
    }
    
    input {
      padding: 12px 15px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      font-size: 16px;
      transition: border 0.3s;
    }
    
    input:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 2px rgba(74, 107, 255, 0.2);
    }
    
    .card-details {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    
    button {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 14px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s, transform 0.2s;
    }
    
    button:hover {
      background-color: #3a5bef;
      transform: translateY(-2px);
    }
    
    button:active {
      transform: translateY(0);
    }
    
    @media (max-width: 480px) {
      .container {
        padding: 20px;
      }
      
      .card-details {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Paiement sécurisé</h2>
    <div class="payment-methods">
      <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa" />
      <img src="https://img.icons8.com/color/48/000000/mastercard-logo.png" alt="Mastercard" />
      <img src="https://img.icons8.com/color/48/000000/amex.png" alt="Amex" />
    </div>

    <form method="POST" action="traitement_paiement.php">
      <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">

      <div class="form-group">
        <label>Nom sur la carte</label>
        <input type="text" name="nom_carte" required>
      </div>

      <div class="form-group">
        <label>Numéro de carte</label>
        <input type="text" name="numero_carte" required placeholder="1234 5678 9012 3456">
      </div>

      <div class="card-details">
        <div class="form-group">
          <label>Expiration (MM/AA)</label>
          <input type="text" name="expiration" required placeholder="MM/AA">
        </div>

        <div class="form-group">
          <label>CVV</label>
          <input type="text" name="cvv" required placeholder="123">
        </div>
      </div>

      <button type="submit">Payer maintenant</button>
    </form>
  </div>
</body>
</html>