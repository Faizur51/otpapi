<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('send.withotp') }}">
        @csrf

            <div>
                <x-label for="mobile" :value="__('Mobile')" />

                <x-input id="mobile" class="block mt-1 w-full" type="text" name="mobile"  required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4 otp">
                <x-label for="otp" :value="__('OTP')" />

                <x-input id="otp" class="block mt-1 w-full" type="text" name="otp" required />
            </div>

            <div class="flex items-center justify-end mt-4 otp">
                <x-button>
                    {{ __('Login') }}
                </x-button>
            </div>
            <div class="flex items-center justify-end mt-4 sendotp" onclick="sendOTP()">
                <x-button>
                    {{ __('Send OTP') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>


    <script>
        $('.otp').hide()

       function sendOTP(){
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           $.ajax({
               url:'sendotp',
               type:'post',
               data:{
                   'mobile':$('#mobile').val()
               },
               success:function (data){
                if(data ==1){
                    $('.otp').show()
                    $('.sendotp').hide()
                }else if(data == 0){
                    $('.otp').hide()
                    alert('Mobile number not Found')
                }
               }
           })
       }

    </script>
</x-guest-layout>
