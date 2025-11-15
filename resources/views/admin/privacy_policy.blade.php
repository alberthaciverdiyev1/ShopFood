<form action="{{ url('/privacy-policy') }}" method="POST">
    @csrf
    <textarea name="content" rows="10" cols="80">{{ $policy->content ?? '' }}</textarea>
    <button type="submit">Yadda saxla</button>
</form>
