@extends('admin.admin_slidebar')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/web3@1.3.6/dist/web3.min.js"></script>
<script>
          async function getEthereumAddress() {
    // Check if MetaMask is installed
    if (window.ethereum) {
      try {
        // Request access to the user's accounts
        await window.ethereum.request({ method: 'eth_requestAccounts' });
        let web3 = new Web3 ('http://localhost:5545');

        // Get the user's Ethereum address
        const accounts = await window.ethereum.request({ method: 'eth_accounts' });

        // Display the address
       // alert('Ethereum Address: ' + accounts[0]);
       myWallet = document.getElementById('idWallet');
       Alladdress = document.getElementById('userList');
       let Allaccounts = await web3.eth.getAccounts ();
         // Get the container element
         // Get the container element
            const userList = document.getElementById('userList');

          // Create a Tailwind list group
          const listGroup = document.createElement('ol');
          listGroup.classList.add('list-decimal', 'p-2');

          // Iterate through the Allaccounts array and create list items
          Allaccounts.forEach(account => {
            const listItem = document.createElement('li');
            listItem.classList.add('mb-2');
            
            listItem.textContent = account;
            listGroup.appendChild(listItem);
          });

          // Append the list group to the container
          userList.appendChild(listGroup);
                      //account 
    
      } catch (error) {
        console.error('Error getting Ethereum address:', error);
      }
    } else {
      alert('MetaMask is not installed. Please install MetaMask and try again.');
    }
  }
  //prevent buttonn click twice 
  
  </script>
  
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
      
      <!-- With actions -->
      
      <div class="flex my-4 items-center space-x-4 text-sm">
        <h4
          class="m-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
        >
          Users Table
        </h4>
        <form action="{{ route('client.create') }}" method="get">
          <button
            class=" items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:bg-gray-400 focus:outline-none focus:shadow-outline-gray"
            aria-label="Create New"
          >
          Create New
          </button>
        </form>
        @if(session('success'))
            <div class="bg-green-100 text-center border border-green-400 text-green-700 px-4 py-2 mt-4">
                {{ session('success') }}
            </div>
        @endif

      </div>
      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
              >
                <th class="px-4 py-3">Client</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Actions</th>
              </tr>
            </thead>
            <tbody
              class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
            @foreach ($users as $user)
                
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <!-- Avatar with inset shadow -->
                    <div
                      class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                    >
                      <img
                        class="object-cover w-full h-full rounded-full"
                        src="{{ $user->image }}"
                        {{-- src="{{ asset('storage/images/'.$user->image)   }}" --}}
                        alt="image"
                        loading="lazy"
                      />
                      <div
                        class="absolute inset-0 rounded-full shadow-inner"
                        aria-hidden="true"
                      ></div>
                    </div>
                    <div>
                      <p class="font-semibold">{{ $user->name }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-3 text-sm">
                    {{ $user->email }}
                </td>
                <td class="px-4 py-3 text-xs">
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600"
                            >
                            {{ $user->role }}
                            </span>
                </td>
                <td class="px-4 py-3 text-sm">
                    {{ $user->created_at }}
                </td>
                <td class="px-4 py-3">
                  <div class="flex items-center space-x-4 text-sm">
                    <form action="{{ route('client.destroy', $user->id ) }}" method="post">
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
                Showing {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }}
            </span>
            <span class="col-span-2"></span>
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                        <li>
                          <a href="{{ $users->previousPageUrl() }}"
                          class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                          aria-label="Previous" @if(!$users->previousPageUrl()) disabled @endif
                        >
                        <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                        </a>
                           
                        </li>
                        
                        <li>
                            <a href="{{ $users->nextPageUrl() }}"
                                class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                                aria-label="Next"
                                @if(!$users->nextPageUrl()) disabled @endif
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
        <div class="col-md-6">
          <div id="postlist">
          </div>
          
      </div>
      <div class="col-md-6">
        <div class="panel">
          <div class="panel-heading">
              <div class="text-center">
                  <div class="row">
                      <div class="col-sm-9">
                          <h3 class="pull-left">Local Service Ethereum Network user</h3>
                      </div>
                      <div class="col-sm-3">
                          <h4 class="pull-right">
                          <small><em>user Blockchain List</em></small>
                          </h4>
                      </div>
                  </div>
              </div>
          </div>
          
          
      </div>
      
      
  </div>
  
 
</div>
        <div id="userList" class="container">

      </div>
      </div>
    </div>
  </main>


</div>
</div>
<script>
  async function getEthereumAddress() {
// Check if MetaMask is installed
if (window.ethereum) {
  try {
    // Request access to the user's accounts
    await window.ethereum.request({ method: 'eth_requestAccounts' });

    // Get the user's Ethereum address
    const accounts = await window.ethereum.request({ method: 'eth_accounts' });

    // Display the address
  // alert('Ethereum Address: ' + accounts[0]);
  myWallet = document.getElementById('idWallet');
  address = document.getElementById('addressWallet');
  myWallet.innerHTML= "Connected Wallet : "+accounts[0];
  
  const userAddress = accounts[0];
  //account 
  // Membuat objek web3 dengan provider rpc lokal
  let web3 = new Web3 ('http://localhost:5545');

  // Mendapatkan alamat akun metamask yang aktif
  let clickaccounts = await web3.eth.getAccounts ();
  let clickaddress = accounts [0];
 // console.log(clickaccounts);
  //address.innerHTML = accounts[0];
  } catch (error) {
    console.error('Error getting Ethereum address:', error);
  }
} else {
  alert('MetaMask is not installed. Please install MetaMask and try again.');
}
}
const decimalNumber = 1337;
const hexadecimalValue = decimalNumber.toString(16);
function addEthereumChain() {
  ethereum
    .request({
      method: 'wallet_addEthereumChain',
      params: [
        {
          chainId: '0x539',
          chainName: 'Localhost 5545',
          blockExplorerUrls: ['https://127.0.0.1:5545'],
          nativeCurrency: { symbol: 'ETH', decimals: 18 },
          rpcUrls: ['https://127.0.0.1:5545/'],
        },
      ],
    })
    .then((res) => console.log('add', res))
    .catch((e) => console.log('ADD ERR', e));
}
//get balance

</script>
@endsection