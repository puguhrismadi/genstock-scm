@extends('admin.admin_slidebar')

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">

      
      <!-- With actions -->
      <h4
        class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
      >
        Accceped Demand
      </h4>
      @if(session('success'))
            <div class="bg-green-100 text-center border border-green-400 text-green-700 px-4 py-2 mt-4">
                {{ session('success') }}
            </div>
        @endif
      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
              >
                <th class="px-4 py-3">Client</th>
                <th class="px-4 py-3">Produit</th>
                <th class="px-4 py-3">service</th>
                <th class="px-4 py-3">Quantity</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Actions</th>
              </tr>
            </thead>
            <tbody
              class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
            @foreach ($accepted as $produit)
                
            <tr class="text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">
                <div class="flex items-center text-sm">
                
                  <div>
                    <p class="font-semibold">{{ $produit->username }}</p>
                  </div>
                </div>
              </td>
              <td class="px-4 py-3 text-sm">
                  {{ $produit->product }}
              </td>
              <td class="px-4 py-3 text-sm">
                  {{ $produit->service }}
              </td>
              <td class="px-4 py-3 text-xs">
                @foreach ($stock as $p)
                @if ($p->product === $produit->product)
                  @if ($produit->Quantity < $p->Quantity)
                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                      {{ $produit->Quantity }}
                    </span>
                  @else
                    <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-white dark:bg-red-600">
                      {{ $produit->Quantity }}
                    </span>
                  @endif
                  @break
                @endif
              @endforeach
              </td>
              <td class="px-4 py-3 text-xs">
                <span
                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                >
                {{ $produit->status }}
              </span>
              </td>

              <td class="px-4 py-3 text-sm">
                  {{ $produit->created }}
              </td>
              <td class="px-4 py-3">
                <div class="flex items-center space-x-4 text-sm">
                  <form action="{{ route('demende.destroy', $produit->id ) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button
                      class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                      aria-label="Delete"
                    >
                      <svg
                        class="w-5 h-5"
                        aria-hidden="true"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
          <span class="flex items-center col-span-3">
              Showing {{ $accepted->firstItem() }}-{{ $accepted->lastItem() }} of {{ $accepted->total() }}
          </span>
          <span class="col-span-2"></span>
          <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
              <nav aria-label="Table navigation">
                  <ul class="inline-flex items-center">
                      <li>
                        <a href="{{ $accepted->previousPageUrl() }}"
                        class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                        aria-label="Previous" @if(!$accepted->previousPageUrl()) disabled @endif
                      >
                      <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                          <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                      </svg>
                      </a>
                         
                      </li>
                      
                      <li>
                          <a href="{{ $accepted->nextPageUrl() }}"
                              class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                              aria-label="Next"
                              @if(!$accepted->nextPageUrl()) disabled @endif
                          >
                              <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                  <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                              </svg>
                          </a>
                      </li>
                  </ul>
              </nav>
          </span>
        
      </div>
      </div>
    </div>
    
    <div class="col-md-6 p-4">
      <div class="container">
        <h4
        class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
      >
       Last Transaction Blockchain History
      </h4>
      <table class="w-full whitespace-no-wrap">
        <thead>
          <tr
            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
          >
            <th class="px-4 py-3">Transaction Hash</th>

          </tr>
        </thead>
        <tbody
          class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
        ><tr>
          <td id="transactionHistory"></td>
        </tr>
        </tbody>
      </table>
       
      </div>
    </div>
  </main>
  <script>
    document.addEventListener('DOMContentLoaded', async function () {
      // Check if MetaMask is installed
      if (window.ethereum) {
        // Initialize Web3.js with MetaMask's provider
        window.web3 = new Web3(window.ethereum);
  
        // Request account access if needed
        await window.ethereum.enable();

        //get list transactions 
        // Get the user's selected address
          const accounts = await window.web3.eth.getAccounts();
          const userAddress = accounts[0];
          const transactionHistoryContainer = document.getElementById('transactionHistory');
          // Get transaction count for the user's address
          const transactionCount = await window.web3.eth.getTransactionCount(userAddress);

          // Display transaction history
          for (let i = 0; i < transactionCount; i++) {
              const transaction = await window.web3.eth.getTransactionFromBlock('latest', i);
              const transactionHtml = `<div><strong>Transaction Hash:</strong> ${transaction.hash}<br><strong>From:</strong> ${transaction.from}<br><strong>To:</strong> ${transaction.to}<br><strong>Value:</strong> ${window.web3.utils.fromWei(transaction.value, 'ether')} ETH<br><br></div>`;
              transactionHistoryContainer.innerHTML += transactionHtml;
          }
      } else {
        alert('MetaMask is not installed. Please install MetaMask and try again.');
      }
  
      const sendTransactionButton = document.getElementById('sendTransactionButton');
  
      // Add click event listener to the button
      sendTransactionButton.addEventListener('click', async function () {
        try {
          // Get the user's selected address
          const accounts = await window.web3.eth.getAccounts();
          const fromAddress = accounts[0];
  
          // Specify the transaction parameters
          const transactionParameters = {
            from: fromAddress,
            to: '0x2278Ff216B544D55328DD9E7EDEA12836c905b15', // Replace with the recipient's address
            value: window.web3.utils.toWei('1', 'ether'), // Replace with the amount to send
          };
  
          // Send the transaction
          const transactionHash = await window.web3.eth.sendTransaction(transactionParameters);
  
          console.log('Transaction Hash:', transactionHash);
          alert('Transaction sent successfully! Transaction hash: ' + transactionHash);
        } catch (error) {
          console.error('Error sending transaction:', error);
          alert('Error sending transaction. Please check the console for details.');
        }
      });
    });

    
  </script>
  @endsection