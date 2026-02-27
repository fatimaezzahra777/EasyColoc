Bonjour,

Vous êtes invité(e) à rejoindre la colocation :
{{ $invitation->colocation->name }}

Cliquez sur ce lien pour accepter :

{{ route('colocations.invitations.accept', $invitation->token) }}