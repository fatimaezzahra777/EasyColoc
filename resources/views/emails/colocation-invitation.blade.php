Bonjour,

Vous êtes invité(e) à rejoindre la colocation :
{{ $invitation->colocation->name }}

Cliquez sur ce lien pour accepter :

{{ route('invitations.accept', $invitation->token) }}