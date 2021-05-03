<?php
$schranka = imap_open("{imap.seznam.cz:993/imap/ssl}INBOX", "27b75fca-c130943a@ondrejaugusta.cz", "ij9q8egkTDgMwpy")
     or die("Nelze se připojit: " . imap_last_error());
     
function subject() {
    $schranka = imap_open("{imap.seznam.cz:993/imap/ssl}INBOX", "27b75fca-c130943a@ondrejaugusta.cz", "ij9q8egkTDgMwpy")
     or die("Nelze se připojit: " . imap_last_error());
        $vysledek = imap_fetch_overview($schranka,imap_num_msg($schranka),0);
        foreach ($vysledek as $email) {
            $sub = imap_utf8($email->subject);
        }
    return $sub;
    imap_close($schranka);
}

function body() {
    $schranka = imap_open("{imap.seznam.cz:993/imap/ssl}INBOX", "27b75fca-c130943a@ondrejaugusta.cz", "ij9q8egkTDgMwpy")
     or die("Nelze se připojit: " . imap_last_error());
        $vysledek = imap_fetch_overview($schranka,imap_num_msg($schranka),0);
        foreach ($vysledek as $email) {
            $body = quoted_printable_decode(imap_fetchbody($schranka,imap_num_msg($schranka),1));
        }
    return $body;
    imap_close($schranka);
}

?>
