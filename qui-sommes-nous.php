<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$page_title = get_current_language() == 'fr' ? 'Qui sommes-nous' : (get_current_language() == 'en' ? 'About Us' : 'Kuhusu Sisi');
$page_description = get_current_language() == 'fr' ? 'Découvrez l\'histoire, la mission et les valeurs de l\'OSPDU' : (get_current_language() == 'en' ? 'Discover the history, mission and values of OSPDU' : 'Gundua historia, dhamira na maadili ya OSPDU');

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-gradient py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 text-shadow">
            <?php echo get_current_language() == 'fr' ? 'Qui sommes-nous' : (get_current_language() == 'en' ? 'About Us' : 'Kuhusu Sisi'); ?>
        </h1>
        <p class="text-xl text-white max-w-3xl mx-auto text-shadow">
            <?php 
            if (get_current_language() == 'fr') {
                echo "Découvrez l'histoire inspirante de l'OSPDU, notre mission et notre engagement pour un monde plus équitable.";
            } elseif (get_current_language() == 'en') {
                echo "Discover the inspiring story of OSPDU, our mission and our commitment to a more equitable world.";
            } else {
                echo "Gundua hadithi ya kutia moyo ya OSPDU, dhamira yetu na dhamana yetu kwa ulimwengu wa haki zaidi.";
            }
            ?>
        </p>
    </div>
</section>

<!-- Section À propos -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="animate-on-scroll">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                    <?php echo get_current_language() == 'fr' ? 'À propos de nous' : (get_current_language() == 'en' ? 'About Us' : 'Kuhusu Sisi'); ?>
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "L'OSPDU (Organe Solidaire pour la Protection Sociale et le Développement Durable) est une organisation humanitaire dédiée à la promotion de l'égalité des genres, à la protection des droits humains et au développement durable des communautés vulnérables.";
                    } elseif (get_current_language() == 'en') {
                        echo "OSPDU (Solidarity Organization for Social Protection and Sustainable Development) is a humanitarian organization dedicated to promoting gender equality, protecting human rights and sustainable development of vulnerable communities.";
                    } else {
                        echo "OSPDU (Shirika la Umoja kwa Ulinzi wa Kijamii na Maendeleo Endelevu) ni shirika la kibinadamu lililojitolea kukuza usawa wa kijinsia, kulinda haki za binadamu na maendeleo endelevu ya jamii zilizo hatarini.";
                    }
                    ?>
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-8">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Fondée sur les principes de solidarité, d'équité et de justice sociale, notre organisation s'engage à créer un impact positif et durable dans la vie des personnes les plus vulnérables de notre société.";
                    } elseif (get_current_language() == 'en') {
                        echo "Founded on the principles of solidarity, equity and social justice, our organization is committed to creating a positive and lasting impact in the lives of the most vulnerable people in our society.";
                    } else {
                        echo "Imeanzishwa kwa misingi ya umoja, haki na haki za kijamii, shirika letu limejitolea kuunda athari chanya na ya kudumu katika maisha ya watu walio hatarini zaidi katika jamii yetu.";
                    }
                    ?>
                </p>
            </div>
            <div class="animate-on-scroll">
                <img src="assets/images/about-team.jpg" alt="Notre équipe" class="rounded-lg shadow-lg w-full h-96 object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Section Historique -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Historique de l\'OSPDU' : (get_current_language() == 'en' ? 'History of OSPDU' : 'Historia ya OSPDU'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Une initiative née d'un engagement profond pour l'égalité des genres";
                } elseif (get_current_language() == 'en') {
                    echo "An initiative born from a deep commitment to gender equality";
                } else {
                    echo "Mpango ulioongozwa na dhamana ya kina kwa usawa wa kijinsia";
                }
                ?>
            </p>
        </div>

        <div class="space-y-12">
            <!-- 2016 - Les débuts -->
            <div class="flex flex-col lg:flex-row items-center gap-8 animate-on-scroll">
                <div class="lg:w-1/3">
                    <div class="bg-primary-blue text-white rounded-full w-20 h-20 flex items-center justify-center text-2xl font-bold mx-auto lg:mx-0">
                        2016
                    </div>
                </div>
                <div class="lg:w-2/3">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo get_current_language() == 'fr' ? 'Les débuts - Une prise de conscience' : (get_current_language() == 'en' ? 'The beginning - An awakening' : 'Mwanzo - Kuamka'); ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        <?php 
                        if (get_current_language() == 'fr') {
                            echo "L'histoire de l'OSPDU trouve son origine en 2016, au sein d'un établissement scolaire du territoire de Rutshuru, dans la cité de Kiwanja. C'est là qu'une jeune fille, Glodi Chochi Awatarsing, alors âgée de 16 ans et élève en cinquième année secondaire, a été frappée par une réalité alarmante : 85 % des élèves qui abandonnaient l'école étaient des filles.";
                        } elseif (get_current_language() == 'en') {
                            echo "The history of OSPDU has its origins in 2016, within a school in the territory of Rutshuru, in the town of Kiwanja. It was there that a young girl, Glodi Chochi Awatarsing, then 16 years old and a student in fifth year of secondary school, was struck by an alarming reality: 85% of students who dropped out of school were girls.";
                        } else {
                            echo "Historia ya OSPDU inaanzia mwaka 2016, katika shule moja katika eneo la Rutshuru, katika mji wa Kiwanja. Hapo ndipo msichana mmoja, Glodi Chochi Awatarsing, aliyekuwa na umri wa miaka 16 na mwanafunzi wa mwaka wa tano wa sekondari, aliguswa na ukweli wa kutisha: asilimia 85 ya wanafunzi walioacha shule walikuwa wasichana.";
                        }
                        ?>
                    </p>
                </div>
            </div>

            <!-- 2017 - Création de O.S.P.I.F -->
            <div class="flex flex-col lg:flex-row-reverse items-center gap-8 animate-on-scroll">
                <div class="lg:w-1/3">
                    <div class="bg-secondary-blue text-white rounded-full w-20 h-20 flex items-center justify-center text-2xl font-bold mx-auto lg:mx-0">
                        2017
                    </div>
                </div>
                <div class="lg:w-2/3">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo get_current_language() == 'fr' ? 'Formalisation - Création de O.S.P.I.F' : (get_current_language() == 'en' ? 'Formalization - Creation of O.S.P.I.F' : 'Kurasimisha - Kuanzishwa kwa O.S.P.I.F'); ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        <?php 
                        if (get_current_language() == 'fr') {
                            echo "En juillet 2017, Glodi Chochi décide de formaliser son engagement en créant une association nommée O.S.P.I.F (Organe Social pour la Protection et l'Intégration de la Femme). Cette première version de l'organisation avait pour objectifs de former et accompagner les femmes dans l'entrepreneuriat, soutenir les femmes vulnérables et favoriser le dialogue et la solidarité féminine.";
                        } elseif (get_current_language() == 'en') {
                            echo "In July 2017, Glodi Chochi decided to formalize her commitment by creating an association called O.S.P.I.F (Social Organization for the Protection and Integration of Women). This first version of the organization aimed to train and support women in entrepreneurship, support vulnerable women and promote dialogue and female solidarity.";
                        } else {
                            echo "Mnamo Julai 2017, Glodi Chochi aliamua kurasimisha dhamana yake kwa kuanzisha chama kinachoitwa O.S.P.I.F (Shirika la Kijamii kwa Ulinzi na Ujumuishaji wa Wanawake). Toleo hili la kwanza la shirika lilikuwa na malengo ya kufundisha na kusaidia wanawake katika ujasiriamali, kusaidia wanawake walio hatarini na kukuza mazungumzo na umoja wa kike.";
                        }
                        ?>
                    </p>
                </div>
            </div>

            <!-- 2024 - Transformation en OSPDU -->
            <div class="flex flex-col lg:flex-row items-center gap-8 animate-on-scroll">
                <div class="lg:w-1/3">
                    <div class="bg-green-600 text-white rounded-full w-20 h-20 flex items-center justify-center text-2xl font-bold mx-auto lg:mx-0">
                        2024
                    </div>
                </div>
                <div class="lg:w-2/3">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo get_current_language() == 'fr' ? 'Évolution - De O.S.P.I.F à OSPDU' : (get_current_language() == 'en' ? 'Evolution - From O.S.P.I.F to OSPDU' : 'Mabadiliko - Kutoka O.S.P.I.F hadi OSPDU'); ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        <?php 
                        if (get_current_language() == 'fr') {
                            echo "En août 2024, Glodi Chochi et son équipe prennent une décision cruciale : élargir les objectifs de l'association et changer son nom en OSPDU. Désormais, OSPDU agit auprès de toutes les populations vulnérables, en mettant un accent particulier sur l'éducation et l'autonomisation des filles et des femmes, l'aide aux populations en détresse, la lutte pour l'égalité des genres et le développement durable.";
                        } elseif (get_current_language() == 'en') {
                            echo "In August 2024, Glodi Chochi and her team made a crucial decision: to broaden the association's objectives and change its name to OSPDU. Now, OSPDU works with all vulnerable populations, with a particular focus on education and empowerment of girls and women, helping populations in distress, fighting for gender equality and sustainable development.";
                        } else {
                            echo "Mnamo Agosti 2024, Glodi Chochi na timu yake walifanya uamuzi muhimu: kupanua malengo ya chama na kubadilisha jina lake kuwa OSPDU. Sasa, OSPDU inafanya kazi na watu wote walio hatarini, ikilenga hasa elimu na uwezeshaji wa wasichana na wanawake, kusaidia watu walio katika dhiki, kupigania usawa wa kijinsia na maendeleo endelevu.";
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Mission, Vision, Valeurs -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Mission -->
            <div class="text-center animate-on-scroll">
                <div class="w-20 h-20 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-bullseye text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo get_current_language() == 'fr' ? 'Notre Mission' : (get_current_language() == 'en' ? 'Our Mission' : 'Dhamira Yetu'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Promouvoir l'égalité des genres, protéger les droits des personnes vulnérables et contribuer au développement durable des communautés à travers des actions concrètes et inclusives.";
                    } elseif (get_current_language() == 'en') {
                        echo "Promote gender equality, protect the rights of vulnerable people and contribute to the sustainable development of communities through concrete and inclusive actions.";
                    } else {
                        echo "Kukuza usawa wa kijinsia, kulinda haki za watu walio hatarini na kuchangia maendeleo endelevu ya jamii kupitia vitendo halisi na vya ujumuishaji.";
                    }
                    ?>
                </p>
            </div>

            <!-- Vision -->
            <div class="text-center animate-on-scroll">
                <div class="w-20 h-20 bg-secondary-blue rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-eye text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo get_current_language() == 'fr' ? 'Notre Vision' : (get_current_language() == 'en' ? 'Our Vision' : 'Maono Yetu'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Un monde où chaque individu, indépendamment de son genre, de son origine ou de sa condition sociale, a accès aux mêmes opportunités et peut vivre dans la dignité et l'équité.";
                    } elseif (get_current_language() == 'en') {
                        echo "A world where every individual, regardless of gender, origin or social condition, has access to the same opportunities and can live with dignity and equity.";
                    } else {
                        echo "Ulimwengu ambapo kila mtu, bila kujali jinsia, asili au hali ya kijamii, ana upatikanaji wa fursa sawa na anaweza kuishi kwa utu na haki.";
                    }
                    ?>
                </p>
            </div>

            <!-- Valeurs -->
            <div class="text-center animate-on-scroll">
                <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo get_current_language() == 'fr' ? 'Nos Valeurs' : (get_current_language() == 'en' ? 'Our Values' : 'Maadili Yetu'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Solidarité, équité, transparence, respect de la dignité humaine, inclusion, innovation sociale et engagement communautaire sont les piliers qui guident toutes nos actions.";
                    } elseif (get_current_language() == 'en') {
                        echo "Solidarity, equity, transparency, respect for human dignity, inclusion, social innovation and community engagement are the pillars that guide all our actions.";
                    } else {
                        echo "Umoja, haki, uwazi, heshima ya utu wa binadamu, ujumuishaji, uvumbuzi wa kijamii na ushiriki wa kijamii ni nguzo zinazongoza vitendo vyetu vyote.";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Section Leadership -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Notre Leadership' : (get_current_language() == 'en' ? 'Our Leadership' : 'Uongozi Wetu'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Un engagement porté par une femme de conviction";
                } elseif (get_current_language() == 'en') {
                    echo "A commitment carried by a woman of conviction";
                } else {
                    echo "Dhamana inayobebwa na mwanamke mwenye imani";
                }
                ?>
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-8 animate-on-scroll">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="md:w-1/3">
                        <img src="assets/images/founder.jpg" alt="Glodi Chochi Awatarsing" class="w-48 h-48 rounded-full object-cover mx-auto shadow-lg">
                    </div>
                    <div class="md:w-2/3">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Glodi Chochi Awatarsing</h3>
                        <p class="text-primary-blue font-semibold mb-4">
                            <?php echo get_current_language() == 'fr' ? 'Fondatrice et Directrice Exécutive' : (get_current_language() == 'en' ? 'Founder and Executive Director' : 'Mwanzilishi na Mkurugenzi Mtendaji'); ?>
                        </p>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            <?php 
                            if (get_current_language() == 'fr') {
                                echo "Glodi Chochi Awatarsing n'a jamais cessé de se battre pour l'humanité. Dès son plus jeune âge, elle s'est engagée pour défendre les droits des filles, des femmes et des personnes vulnérables. Son rêve d'un monde plus juste l'a amenée à fonder OSPDU, et son leadership continue d'inspirer des générations entières.";
                            } elseif (get_current_language() == 'en') {
                                echo "Glodi Chochi Awatarsing has never stopped fighting for humanity. From a young age, she has been committed to defending the rights of girls, women and vulnerable people. Her dream of a more just world led her to found OSPDU, and her leadership continues to inspire entire generations.";
                            } else {
                                echo "Glodi Chochi Awatarsing hajawahi kuacha kupigania ubinadamu. Tangu utotoni, amejitolea kulinda haki za wasichana, wanawake na watu walio hatarini. Ndoto yake ya ulimwengu wa haki zaidi ilimsababishia kuanzisha OSPDU, na uongozi wake unaendelea kutia moyo vizazi nzima.";
                            }
                            ?>
                        </p>
                        <p class="text-gray-600 dark:text-gray-300">
                            <?php 
                            if (get_current_language() == 'fr') {
                                echo "Aujourd'hui, en plus de son engagement humanitaire, elle est une femme mariée et mère de deux enfants, mais sa mission reste intacte : créer un avenir où l'égalité, la dignité et la solidarité sont des valeurs universelles.";
                            } elseif (get_current_language() == 'en') {
                                echo "Today, in addition to her humanitarian commitment, she is a married woman and mother of two children, but her mission remains intact: to create a future where equality, dignity and solidarity are universal values.";
                            } else {
                                echo "Leo, mbali na dhamana yake ya kibinadamu, ni mwanamke aliyeoa na mama wa watoto wawili, lakini dhamira yake inabaki bila kubadilika: kuunda mustakabali ambapo usawa, utu na umoja ni maadili ya ulimwengu.";
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Appel à l'action -->
<section class="py-16 hero-gradient">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <div class="animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                <?php echo get_current_language() == 'fr' ? 'Rejoignez notre cause' : (get_current_language() == 'en' ? 'Join our cause' : 'Jiunge na sababu yetu'); ?>
            </h2>
            <p class="text-xl text-white mb-8">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Ensemble, nous pouvons faire la différence et créer un impact positif dans la vie des plus vulnérables.";
                } elseif (get_current_language() == 'en') {
                    echo "Together, we can make a difference and create a positive impact in the lives of the most vulnerable.";
                } else {
                    echo "Pamoja, tunaweza kuleta mabadiliko na kuunda athari chanya katika maisha ya walio hatarini zaidi.";
                }
                ?>
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="s-impliquer.php" class="bg-white text-primary-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-300">
                    <?php echo get_current_language() == 'fr' ? 'S\'impliquer' : (get_current_language() == 'en' ? 'Get Involved' : 'Jiunge Nasi'); ?>
                </a>
                <a href="contact.php" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-blue transition-all duration-300">
                    <?php echo get_current_language() == 'fr' ? 'Nous contacter' : (get_current_language() == 'en' ? 'Contact Us' : 'Wasiliana Nasi'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>