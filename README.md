Riga Coding School WEB Bootcamp (15.09.) Final Project (Social Media)

Uztaisīju datubāzes tabulu uzbūvi/struktūru - ir iekš projekta ar nosaukumu 'database'.

PHP_MAILER nav iekļauts projektā - bija problēmas ar github push sen atpakaļ, tāpēc ja ir vēlme pārbaudīt vai strādā, tad: 

1)Jānolādē PHP Mailer https://github.com/PHPMailer/PHPMailer 

2)forgot_pass.php -> line 8,9,10 jānorāda pareizie ceļi un jānomaina "MY_EMAIL" un "MY_PASSWORD" ar īstu gmail lietotājvārdu un paroli, respektīvi. 

3)Ja tiek izmantots gmail -> google konts kurš tika izmantots -> settings -> Less secure app access -> ON. Pēc noklusējuma ir OFF. Manā gadījumā tas izlaboja problēmu, 
kad pirmo reizi mēģināju nosūtīt uz epastu paroles atjaunošanas linku. 

4)login_controller.php -> line 4 -> atkomentēt forgot_pass.php.

Ko es iemācījos projekta izpildes ietvarā:

1)MVC ir laba lieta - ļoti viegli orientēties pa failiem ja kodu rindas iet pāri 200+. Ir mape ar nosaukumu 'includes', kura satur navigācijas līknes (header) un banera (jumbotron) kontrolierus un view failus. Nospriedu nepārrakstīt visu to kodu, ja ir jāizmanto uz daudzām lapām viens un tas pats koda bloks.

2)Nebaidīties dot, ja nepieciešams, garākus nosaukumus mainīgajiem.

3)Label -> label for "xyz" un xyz failam var uzlikt display:none. Tādā veidā es daudzviet panācu to, ka var nospiest uz, piemēram, bildes un īstenībā tiek nospiesta neredzama poga. Ar javascript sākumā es rakstīju $('#something').click(e=>{$('#something_else').click()}), bet problēma ar to bija ka tas neļauj izvēlēties failu, ja tiek izmantots input="file".

4)Labāk ir izdomāt failu struktūru un dizainu sākumā, nevis projekta vidū. Ja vajadzētu vēlreiz tādu pašu darbu uztaisīt, es taisītu vairāk izmantojot JSON - Instagramā, 
teiksim, ja nospiež uz kādas bildes, lapa netiek pārlādēta. Ir pieeja komentāriem utml. iespēja atstāt like utt. Manā gadījumā uz praktiski visām darbībām lapa pārlādējas 
vietās, kur bez tā var iztikt un otrādi. Search funkcija, teiksim, neuztaisa GET lapu, bet vajadzētu. Nospiežot uz kāda posta, tiek uztaisīts GET pieprasījums, bet labāk būtu ja visi komentāri utt ir jau ielādēti visiem postiem un nospiežot tie tiek front end jau parādīti.

5)Daudz drošības pasākumu: strip tags, sql attacks, real_escape_string, password utml hashing, str_replace(' ', ''), pārbaude vai fails ko lietotājs mēģina augšuplādēt tie
šām ir fails, kuru sagaidām, vai tā izmērs nav vairāki terabaiti utt.

6)Nav labi saglabāt pašas bildes datubāzē - labāk ir saglabāt lokāli uz dzelža un norādīt ceļu datubāzē. Tai pašā laikā, netērēt lieki datus un vecos failus dzēst ārā - 
teiskim, ja lietotājs izdomā nomainīt savu profila bildi, tad veco bildi nav vērts glabāt.

7)Faili netiek atpazīti, ja faila nosaukums satur atstarpes. Tāpēc noskaukumi tiek iedoti unikāli, balstoties un user id (katram lietotājam ir tikai 1 sava bilde, kura tiek glabāta mapē profile_pics) vai balstoties uz post id. 

Problēmas:

Bootrsap collapse navbar poga nedarbojas uz pavisam mazām ierīcēm - ja ievieto bootrsap jquery tad nestrādā parastā jquery slide opcijas. Nolēmu atstāt kā ir, jo man ne
patīk kā izskatās navbar, kas samazina izmērus līdz bootstrap sm- 

Ja profila bilde automātiski neatjaunojas uz jauno, tad vajag tasiīt hard reload un pēc tam visas nākamās bildes atjaunosies kā tam paredzēts. Lasīju stackoverflow, ka bildes nosaukumam nemainoties bildes vērtība tiek iekešota. Viens risinājums ir pielikt ?ver=1,2,3 utt. kas liktu lapai ielādēties no jauna.

Random komentārs: 

Translācijas laikā man neizdevās nodemonstrēt ka nav iespējams piekļū bildei, ja ir noņemta redzamība - aizejot uz linku bildīte tāpat atvērās. Tā tam bija jānotiek, jo es nebiju izlogojies no profila un iegājis kādā citā, svešā profilā. Pašam lietotājam IR piekļuve saviem neredzamajiem postiem
