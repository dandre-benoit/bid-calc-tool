# The Bid Calculation Tool

## Objective
The purpose of the following exercise is to assess a programmer's ability to develop a minimum viable product. Note that this exercise does not simulate a real work situation. The objective is to develop a simple application using good programming practices. 

## Details 
- We expect a web application 
- Since we are looking for a full-stack developer, you need to provide one backend and one frontend communicating together 
- The programming language to use for the backend is the one specified in the job description 
- The frontend (UI) should be built using an appropriate framework (ideally Vue.js) 
- The code must be submitted via GitHub 

## Evaluation Criteria 
The final solution will be evaluated according to the following criteria, **taking into account the expected level of experience:**
- Clarity and readability of code, formatting, naming conventions, etc. 
- Algorithm and calculation results 
- Use of Object-Oriented Programming principles 
- Implementation of good software architecture practices (Clean Code, SOLID, KISS, DRY, YAGNI, etc.) 
- Proper use of frameworks, tools, and libraries related to the programming language used 
- Implementation of unit tests 

## Task Description 
Develop an application that will allow a buyer to calculate the total price of a vehicle (common or luxury) at a car auction. The software must consider several costs in the calculation. The buyer must pay various fees for the transaction, all of which are calculated on the base price amount. The total amount calculated is the winning bid amount (vehicle base price) plus the fees based on the vehicle price and vehicle type. Fees must be dynamically computed. 

## Requirements
- There is a field to enter the vehicle base price 
- There is a field to specify the vehicle type (Common or Luxury) 
- The list of fees and their amount are displayed 
- The total cost is automatically computed and displayed every time the price or type changes 

## Fixed and Variable Costs 
 
- Basic buyer fee: 10% of the price of the vehicle 
  - Common: minimum $10 and maximum $50 
  - Luxury: minimum $25 and maximum $200
- The seller's special fee: 
  - Common: 2% of the vehicle price  
  - Luxury: 4% of the vehicle price 
- The added costs for the association based on the price of the vehicle: 
  - $5 for an amount between $1 and $500 
  - $10 for an amount greater than $500 up to $1000 
  - $15 for an amount greater than $1000 up to $3000 
  - $20 for an amount over $3000 
- A fixed storage fee of $100 

## Calculation Example 
 
- Vehicle Price (Common): $1000 
- Basic buyer fee: $50 (10%, min: $10, max. $50) 
- Special fee: $20 (2%) 
- Association fee: $10  
- Storage fee: $100  
- **Total:** $1180 = $1000 + $50 + $20 + $10 + $100 

## Test Cases

| Vehicle Price     | Vehicle Type | Basic Fee | Special    | Association   | Storage  | Total            | 
|------------------:|:------------:|----------:|-----------:|--------------:|---------:|-----------------:|
| **$ 398.00** 	    | Common       | $ 39.80   | $ 7.96	    | $ 5.00        | $ 100.00 | **$ 550.76**     |
| **$ 501.00** 	    | Common       | $ 50.00   | $ 10.02  	| $ 10.00       | $ 100.00 | **$ 671.02**     |
| **$ 57.00** 	    | Common       | $ 10.00   | $ 1.14	    | $ 5.00        | $ 100.00 | **$ 173.14**     |
| **$ 1800.00** 	  | Luxury       | $ 180.00  | $ 72.00	  | $ 15.00       | $ 100.00 | **$ 2167.00**    |
| **$ 1100.00** 	  | Common       | $ 50.00   | $ 22.00	  | $ 15.00       | $ 100.00 | **$ 1287.00**    |
| **$ 1000000.00**  | Luxury       | $ 200.00  | $ 40000.00 | $ 20.00       | $ 100.00 | **$ 1040320.00** |

## Extras
- Project setup via .env file
- Importable Postman collection JSON files under ```/postman```
- Responsivity
- Currency formating
- Transition animation
- Message while querying the result
- Error message when the vehicule price is under or equal to zero
- Use of a debounce of 500ms to prevent spaming the backend while typing the vehicule price
- Did both frontend and backend unit testing

## Documentation
- [Project Setup](./docs/setup/index.md)
- [Technologies](./docs/technologies/index.md)

## Production
- [Acknowledgment](./docs/acknowledgment.md)
- [Planning](./docs/planning.md)
- [Timeline](./docs/timeline.md)
