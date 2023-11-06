@php
$url = explode('/',url()->current());
$new_url = end($url);
@endphp
<ul class="custom-nav">
  <li @if($new_url=='dashboard' || $new_url=='admin') class="active" @endif ><a href="{{ url('financialsummary/dashboard') }}"><strong>EXPENSES</strong></a></li>
  <li @if($new_url=='expenses-b') class="active" @endif ><a href="{{ url('financialsummary/expenses-b') }}"><strong>B</strong></a></li>
  <li @if($new_url=='expenses-x') class="active" @endif><a href="{{ url('financialsummary/expenses-x') }}"><strong>X</strong></a></li>
  <li @if($new_url=='stock-purchase') class="active" @endif><a href="{{ url('financialsummary/stock-purchase') }}"><strong>STOCK & PURCHASE</strong></a></li>
  <li @if($new_url=='stock-purchase-b') class="active" @endif><a href="{{ url('financialsummary/stock-purchase-b') }}"><strong>B</strong></a></li>
  <li @if($new_url=='stock-purchase-x') class="active" @endif><a href="{{ url('financialsummary/stock-purchase-x') }}"><strong>X</strong></a></li>
  <li @if($new_url=='sale') class="active" @endif><a href="{{ url('financialsummary/sale') }}"><strong>SALES</strong></a></li>
  <li @if($new_url=='profit-loss') class="active" @endif><a href="{{ url('financialsummary/profit-loss') }}"><strong>P/L SUMMARY</strong></a></li>
  <li id="all-profit-loss" @if($new_url=='all-profit-loss') class="active" @endif @if(getAllProfitLossCheck()==0) style="display:none;" @endif>
  <a href="{{ url('financialsummary/all-profit-loss') }}"><strong>ALL P/L SUMMARY</strong></a>
  </li>
</ul>
<div class="sign-off"><div class="select-box">{!! getCompanyDropdown('company', Auth::user()->id) !!}</div><a onclick="handleSignoutClick()"  href="{{ url('/logout') }}"><strong><i class="fa fa-sign-out" aria-hidden="true"></i></strong></a></div>
